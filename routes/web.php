<?php

use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/purchase', function () {
    return view('purchase');
});

Route::get('/service', function () {
    return view('service');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/signup1', function () {
    return view('signup1');
});

Route::get('/signup2', function () {
    return view('signup2');
});

Route::get('/signup3', function () {
    return view('signup3');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/forgot', function () {
    return view('forgot');
});

Route::get('/get-started', [SignupController::class, 'index']);

Route::post('/signup', [SignupController::class, 'store'])->name('signup');
