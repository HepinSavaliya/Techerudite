<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::get('customer/register',[RegistrationController::class,'customerRegistrationForm'])->name('show.customer.register');
    Route::post('customer/register',[RegistrationController::class,'customerRegistration'])->name('customer.register');

    Route::get('admin/register',[RegistrationController::class,'adminRegistrationForm'])->name('show.admin.register');
    Route::post('admin/register',[RegistrationController::class,'adminRegistration'])->name('admin.register');

    Route::get('login',[LoginController::class,'showLoginForm']);
    Route::post('login',[LoginController::class,'login'])->name('login');

});

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth')
                ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');