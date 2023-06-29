<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Front\FrontController;
use App\Models\Package;
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

Route::get('user/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('user.form.resetPassword');

Route::post('/reset_password', [AuthController::class, 'submitResetPasswordForm'])->name('user.resetPassword');

Route::get('/payments/verify/{payment?}',[FrontController::class,'payment_verify'])->name('payment-verify');

Route::get('/payment/{id}' ,function($id){
    $response = Package::where(['transaction_id' => $id])->first();
    $htmlContent = $response['content'];
    return view('payment-response',compact('htmlContent'));
});
