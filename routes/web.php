<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;


Route::get('/', function () {
    return view('homepage');
});

Route::get('/homepage', function () {
    return view('homepage');
});

Route::get('/browsecatalog', function () {
    return view('browsecatalog');
});

Route::get('/customize', function () {
    return view('customize');
});

Route::get('/support', function () {
    return view('support');
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});