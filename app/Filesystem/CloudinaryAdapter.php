<?php

namespace App\Filesystem;

use Cloudinary\Cloudinary;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

class CloudinaryAdapter implements FilesystemAdapter
{
    protected Cloudinary $cloudinary;
    protected string $folder;

    public function __construct(Cloudinary $cloudinary, string $folder = '')
    {
        $this->cloudinary = $cloudinary;
        $this->folder = $folder;
    }

    public function fileExists(string $path): bool
    {
        try {
            $publicId = $this->getPublicId($path);
            $result = $this->cloudinary->adminApi()->asset($publicId);
            return isset($result['public_id']);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function directoryExists(string $path): bool
    {
        return true; // Cloudinary doesn't have real directories
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $this->writeStream($path, $this->createStreamFromString($contents), $config);
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'cloudinary_');
            file_put_contents($tempFile, stream_get_contents($contents));
            
            $publicId = $this->getPublicId($path);
            
            $this->cloudinary->uploadApi()->upload($tempFile, [
                'public_id' => $publicId,
                'resource_type' => 'auto',
                'overwrite' => true,
            ]);
            
            unlink($tempFile);
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function read(string $path): string
    {
        try {
            $url = $this->publicUrl($path, new Config());
            $contents = file_get_contents($url);
            if ($contents === false) {
                throw new \Exception('Failed to read file');
            }
            return $contents;
        } catch (\Exception $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    public function readStream(string $path)
    {
        try {
            $url = $this->publicUrl($path, new Config());
            $stream = fopen($url, 'r');
            if ($stream === false) {
                throw new \Exception('Failed to open stream');
            }
            return $stream;
        } catch (\Exception $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage(), $e);
        }
    }

    public function delete(string $path): void
    {
        try {
            $publicId = $this->getPublicId($path);
            $this->cloudinary->uploadApi()->destroy($publicId);
        } catch (\Exception $e) {
            throw UnableToDeleteFile::atLocation($path, $e->getMessage(), $e);
        }
    }

    public function deleteDirectory(string $path): void
    {
        // Not implemented for Cloudinary
    }

    public function createDirectory(string $path, Config $config): void
    {
        // Cloudinary auto-creates directories
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // Cloudinary files are always public by default
    }

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, null, 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function lastModified(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function fileSize(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    public function move(string $source, string $destination, Config $config): void
    {
        $this->copy($source, $destination, $config);
        $this->delete($source);
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        $contents = $this->read($source);
        $this->write($destination, $contents, $config);
    }

    public function publicUrl(string $path, Config $config): string
    {
        $publicId = $this->getPublicId($path);
        return $this->cloudinary->image($publicId)->toUrl();
    }

    protected function getPublicId(string $path): string
    {
        // Remove extension for public_id
        $pathInfo = pathinfo($path);
        $pathWithoutExt = $pathInfo['dirname'] === '.' 
            ? $pathInfo['filename'] 
            : $pathInfo['dirname'] . '/' . $pathInfo['filename'];
        
        return $this->folder 
            ? trim($this->folder, '/') . '/' . ltrim($pathWithoutExt, '/')
            : ltrim($pathWithoutExt, '/');
    }

    protected function createStreamFromString(string $content)
    {
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $content);
        rewind($stream);
        return $stream;
    }
}
