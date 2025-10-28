<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk tiket wisata
Route::get('/tiket/{tempat}/{harga}', function ($tempat, $harga) {
    return view('tiket', [
        'tempat' => $tempat,
        'harga' => $harga
    ]);
});
