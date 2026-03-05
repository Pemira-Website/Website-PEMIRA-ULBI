<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

try {
    $files = Storage::disk('gcs')->files('paslon');
    echo "Files in paslon/:\n";
    print_r($files);
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
