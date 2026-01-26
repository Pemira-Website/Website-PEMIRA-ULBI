<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | This is the configuration for Cloudinary. The CLOUDINARY_URL environment
    | variable should be in the format:
    | cloudinary://API_KEY:API_SECRET@CLOUD_NAME
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
];
