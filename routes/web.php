<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/jadwal_mengajar', function () {
    return view('guru.jadwal_mengajar');
});