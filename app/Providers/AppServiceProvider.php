<?php

namespace App\Providers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;

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

        // Register GCS filesystem driver
        Storage::extend('gcs', function ($app, $config) {
            $storageClient = new StorageClient([
                'projectId' => $config['project_id'],
                'keyFile' => $config['key_file'] ?? null,
            ]);

            $bucket = $storageClient->bucket($config['bucket']);
            $pathPrefix = $config['path_prefix'] ?? '';

            $adapter = new GoogleCloudStorageAdapter($bucket, $pathPrefix);
            $filesystem = new Filesystem($adapter);

            return new class($filesystem, $adapter, $config) extends FilesystemAdapter {
                public function url($path)
                {
                    $url = $this->config['url'] ?? ('https://storage.googleapis.com/' . $this->config['bucket'] . '/' . ($this->config['path_prefix'] ?? ''));
                    return rtrim($url, '/') . '/' . ltrim($path, '/');
                }

                public function temporaryUrl($path, $expiration, array $options = [])
                {
                    // Because bucket is public, we can just return the actual URL
                    return $this->url($path); 
                }
            };
        });
    }
}
