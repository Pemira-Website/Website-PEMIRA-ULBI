<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

try {
    $client = new StorageClient([
        'projectId' => 'test-project',
        'keyFile' => null
    ]);
    echo "StorageClient initialized successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
