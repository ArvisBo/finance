<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('/finance');
    // return view('welcome');
});
