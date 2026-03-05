<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

try {
    Storage::disk('gcs')->put('test.txt', 'Hello GCS');
    echo "Success! \n";
    echo "URL: " . Storage::disk('gcs')->url('test.txt');
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
