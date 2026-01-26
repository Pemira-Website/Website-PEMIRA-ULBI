<?php

namespace App\Providers;

use App\Filesystem\CloudinaryAdapter;
use Cloudinary\Cloudinary;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Cloud Run)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Register Cloudinary filesystem driver
        Storage::extend('cloudinary', function ($app, $config) {
            $cloudinaryUrl = env('CLOUDINARY_URL');
            
            if (!$cloudinaryUrl) {
                Log::warning('CLOUDINARY_URL not set, falling back to public disk');
                // Fallback to public disk if Cloudinary not configured
                return Storage::disk('public');
            }

            try {
                $cloudinary = new Cloudinary($cloudinaryUrl);
                
                $adapter = new CloudinaryAdapter(
                    $cloudinary,
                    $config['folder'] ?? 'pemira'
                );

                return new FilesystemAdapter(
                    new Filesystem($adapter, $config),
                    $adapter,
                    $config
                );
            } catch (\Exception $e) {
                Log::error('Failed to initialize Cloudinary: ' . $e->getMessage());
                // Fallback to public disk on error
                return Storage::disk('public');
            }
        });
    }
}
