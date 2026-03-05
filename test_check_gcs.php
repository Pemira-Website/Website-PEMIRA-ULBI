<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "Checking paslon directory on GCS:\n";
$files = Storage::disk('gcs')->files('paslon');
print_r($files);
