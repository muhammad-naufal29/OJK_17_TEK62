<?php

/**
 * Entry point untuk Vercel.
 *
 * Vercel hanya mengizinkan entry point berada di dalam folder `api`,
 * sedangkan entry point asli Laravel ada di `public/index.php`.
 * File ini hanya meneruskan seluruh request ke entry point Laravel tersebut.
 */

// Vercel hanya menyediakan filesystem yang bisa ditulis di /tmp.
// Laravel perlu menulis compiled view & cache, jadi arahkan semuanya ke /tmp.
$writableDirs = [
    '/tmp/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/bootstrap/cache',
];

foreach ($writableDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Database demo memakai SQLite. File databasenya ikut ter-deploy bersama kode,
// lalu disalin ke /tmp (satu-satunya folder yang bisa ditulis di Vercel)
// supaya aplikasi bisa membaca & menulis data.
$bundledDb = __DIR__.'/../database/database.sqlite';
$runtimeDb = '/tmp/database.sqlite';

if (is_file($bundledDb) && ! is_file($runtimeDb)) {
    @copy($bundledDb, $runtimeDb);
}

// Pastikan Laravel selalu memakai SQLite di /tmp, apa pun isi environment.
$_ENV['DB_CONNECTION'] = $_SERVER['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $_SERVER['DB_DATABASE'] = $runtimeDb;
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE='.$runtimeDb);

// Biarkan Laravel menganggap dirinya diakses dari root, bukan dari /api.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';

require __DIR__.'/../public/index.php';
