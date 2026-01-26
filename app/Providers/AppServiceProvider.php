<?php

namespace App\Providers;

use App\Filesystem\CloudinaryAdapter;
use Cloudinary\Cloudinary;
use Illuminate\Filesystem\FilesystemAdapter;
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
                throw new \Exception('CLOUDINARY_URL environment variable is not set');
            }

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
        });
    }
}
