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

// Biarkan Laravel menganggap dirinya diakses dari root, bukan dari /api.
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/../public/index.php';

require __DIR__.'/../public/index.php';
