<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Canonical Program Studi Names
    |--------------------------------------------------------------------------
    |
    | Semua varian nama prodi dinormalisasi ke canonical value ini agar
    | mapping dan permission voting konsisten lintas controller, view, seeder,
    | dan panel admin.
    |
    */
    'prodi_aliases' => [
        'D4 E-Commerce Logistics' => 'D4 Logistik Niaga-EL',
        'D4 Manajemen Bisnis' => 'D4 Manajemen Perusahaan',
        'D3 Manajemen Bisnis' => 'D3 Manajemen Pemasaran',
        'D3 Manajemen informatika' => 'D3 Manajemen Informatika',
    ],

    /*
    |--------------------------------------------------------------------------
    | Canonical Mapping: Program Studi => Jenis HIMA
    |--------------------------------------------------------------------------
    */
    'prodi_to_hima' => [
        'D3 Teknik Informatika' => 'himatif',
        'D4 Teknik Informatika' => 'himatif',
        'S1 Manajemen Logistik' => 'himagis',
        'D3 Administrasi Logistik' => 'himalogbis',
        'D4 Logistik Bisnis' => 'himalogbis',
        'S1 Manajemen Transportasi' => 'himaporta',
        'D3 Manajemen Pemasaran' => 'himanbis',
        'D4 Manajemen Perusahaan' => 'himanbis',
        'D3 Akuntansi' => 'hma',
        'D4 Akuntansi Keuangan' => 'hma',
        'S1 Bisnis Digital' => 'himabig',
        'D4 Logistik Niaga-EL' => 'hicomlog',
        'S1 Sains Data' => 'himasta',
        'S1 Manajemen Rekayasa' => 'himamera',
        'D3 Manajemen Informatika' => 'hmmi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Voting Constraints
    |--------------------------------------------------------------------------
    */
    'special_hima' => [
        'himabig',
        'hicomlog',
        'himamera',
    ],

    'vote_types' => [
        'presma' => 'Presiden Mahasiswa (Presma)',
        'himatif' => 'Himpunan - HIMATIF',
        'himagis' => 'Himpunan - HIMAGIS',
        'himalogbis' => 'Himpunan - HIMALOGBIS',
        'himaporta' => 'Himpunan - HIMAPORTA',
        'himanbis' => 'Himpunan - HIMANBIS',
        'hma' => 'Himpunan - HMA',
        'himabig' => 'Himpunan - HIMABIG',
        'hicomlog' => 'Himpunan - HICOMLOG',
        'himasta' => 'Himpunan - HIMASTA',
        'himamera' => 'Himpunan - HIMAMERA',
        'hmmi' => 'Himpunan - HMMI',
    ],

    /*
    |--------------------------------------------------------------------------
    | Result Visibility Mode
    |--------------------------------------------------------------------------
    |
    | live_public: hasil tampil real-time saat pemungutan aktif
    | closed_until_end: hasil ditutup sampai voting selesai
    |
    */
    'result_visibility_mode' => env('PEMIRA_RESULT_VISIBILITY_MODE', 'live_public'),

    /*
    |--------------------------------------------------------------------------
    | Result Publication State
    |--------------------------------------------------------------------------
    |
    | Digunakan saat mode `closed_until_end`.
    | true  => pemungutan ditutup, hasil boleh dipublikasikan
    | false => pemungutan masih berjalan, hasil publik ditutup
    |
    */
    'voting_closed' => env('PEMIRA_VOTING_CLOSED', false),

    /*
    |--------------------------------------------------------------------------
    | Live Chart Performance Tuning
    |--------------------------------------------------------------------------
    |
    | polling_seconds: interval refresh chart di browser
    | cache_ttl_seconds: TTL cache query chart di server
    |
    */
    'result_polling_seconds' => env('PEMIRA_RESULT_POLLING_SECONDS', 10),
    'result_cache_ttl_seconds' => env('PEMIRA_RESULT_CACHE_TTL_SECONDS', 10),

    /*
    |--------------------------------------------------------------------------
    | Monitoring Thresholds
    |--------------------------------------------------------------------------
    |
    | Ambang batas alert untuk command observability pasca deploy:
    | `php artisan pemira:monitor --fail-on-alert`
    |
    */
    'monitoring_pending_alert_threshold' => env('PEMIRA_PENDING_ALERT_THRESHOLD', 50),
    'monitoring_failed_alert_threshold' => env('PEMIRA_FAILED_ALERT_THRESHOLD', 5),
    'monitoring_stale_processing_minutes' => env('PEMIRA_STALE_PROCESSING_MINUTES', 10),
    'monitoring_queue_backlog_alert_threshold' => env('PEMIRA_QUEUE_BACKLOG_ALERT_THRESHOLD', 100),

    /*
    |--------------------------------------------------------------------------
    | Privacy Mode
    |--------------------------------------------------------------------------
    |
    | auditable: jejak internal vote per pemilih tersimpan
    | strict_anonymous: tidak ada relasi langsung pemilih-vote
    |
    */
    'privacy_mode' => env('PEMIRA_PRIVACY_MODE', 'auditable'),

    /*
    |--------------------------------------------------------------------------
    | Dummy Seed Control
    |--------------------------------------------------------------------------
    |
    | Nonaktif secara default agar startup aplikasi tidak mengisi ulang data
    | pemilih dummy ke database shared. Aktifkan manual saat butuh data contoh
    | untuk development atau demo.
    |
    */
    'seed_dummy_pemilih' => env('PEMIRA_SEED_DUMMY_PEMILIH', false),
];
