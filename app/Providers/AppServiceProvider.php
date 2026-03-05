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
            // Validasi config yang diperlukan
            if (empty($config['project_id']) || empty($config['bucket'])) {
                throw new \RuntimeException('GCS storage requires project_id and bucket configuration.');
            }

            $clientConfig = [
                'projectId' => $config['project_id'],
            ];

            // Hanya set keyFile jika benar-benar ada (bukan null/empty string)
            if (!empty($config['key_file']) && is_array($config['key_file'])) {
                $clientConfig['keyFile'] = $config['key_file'];
            }

            $storageClient = new StorageClient($clientConfig);
            $bucket = $storageClient->bucket($config['bucket']);
            $pathPrefix = $config['path_prefix'] ?? '';

            $adapter = new GoogleCloudStorageAdapter($bucket, $pathPrefix);
            $filesystem = new Filesystem($adapter);

            return new class($filesystem, $adapter, $config) extends FilesystemAdapter {
                /**
                 * Generate public URL untuk file di GCS.
                 * Path yang diberikan sudah relatif terhadap path_prefix,
                 * jadi kita hanya perlu menambahkan ke base URL.
                 */
                public function url($path): string
                {
                    // Jika path sudah berupa full URL, kembalikan langsung
                    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                        return $path;
                    }

                    $bucket = $this->config['bucket'] ?? '';
                    $prefix = $this->config['path_prefix'] ?? '';

                    // Build base URL: https://storage.googleapis.com/{bucket}/{prefix}
                    $baseUrl = $this->config['url']
                        ?? ('https://storage.googleapis.com/' . $bucket . ($prefix ? '/' . trim($prefix, '/') : ''));

                    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
                }

                /**
                 * GCS public bucket tidak perlu signed URL,
                 * kembalikan public URL langsung.
                 */
                public function temporaryUrl($path, $expiration, array $options = []): string
                {
                    return $this->url($path);
                }
            };
        });
    }
}
