<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Project ID
    |--------------------------------------------------------------------------
    |
    | ID proyek Firebase Anda dapat ditemukan di Pengaturan Proyek di Firebase Console.
    |
    */
    'project_id' => env('FIREBASE_PROJECT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Credentials
    |--------------------------------------------------------------------------
    |
    | Path ke file JSON kredensial (Service Account) Firebase Anda.
    | Unduh dari Pengaturan Proyek > Service Accounts di Firebase Console.
    | Sebaiknya simpan di luar direktori publik, misalnya di `storage/app/firebase`.
    |
    */
    'credentials' => storage_path(env('FIREBASE_CREDENTIALS')),

    /*
    |--------------------------------------------------------------------------
    | Firebase Storage Default Bucket
    |--------------------------------------------------------------------------
    |
    | Nama default bucket Firebase Storage Anda. Biasanya dalam format:
    | <project-id>.appspot.com
    |
    */
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
];
