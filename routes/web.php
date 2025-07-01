<?php

use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import', function () {
    return view('import');
});

Route::post('/import', [EnrollmentController::class, 'import'])
     ->name('enrollment.import');
