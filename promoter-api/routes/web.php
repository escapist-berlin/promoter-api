<?php

use Illuminate\Support\Facades\Route;

Route::get('/swagger-documentation', function () {
    return view('swagger');
});