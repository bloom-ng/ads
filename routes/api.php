<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\WhatsAppFlowController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    //All secure URL's
    Route::resource('/invoice', InvoiceController::class);
    Route::resource('/receipt', \App\Http\Controllers\ReceiptController::class);
    Route::resource('/voucher', VoucherController::class);
    Route::resource('/company-info', CompanyInfoController::class);
});

Route::post('/login', [AuthController::class, 'signin']);
Route::post('/signup', [AuthController::class, 'store']);

// Public route for receipt confirmation
Route::get('/receipt/confirm/{receiptCode}', [\App\Http\Controllers\ReceiptController::class, 'confirm']);


// WhatsApp Flow webhook endpoint (public)
Route::post('/whatsapp/flow', [WhatsAppFlowController::class, 'handleFlow'])
    ->name('whatsapp.flow');

Route::get('/webhook/meta', [WebhookController::class, 'verify']);
Route::post('/webhook/meta', [WebhookController::class, 'handle']);
