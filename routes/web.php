<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestFormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RegistrationManagementController;
use App\Http\Controllers\Admin\BatchController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Google OAuth
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Logout (accessible when authenticated)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

// Protected Routes (requires auth and verified email)
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Management
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Registration (requires completed profile)
    Route::middleware('profile.complete')->group(function () {
        Route::get('/registration/create', [RegistrationController::class, 'create'])->name('registration.create');
        Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
    });

    // Dashboard (accessible with or without profile completion)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin Routes (requires auth, verified, and admin role)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Registration Management
    Route::get('/registrations', [RegistrationManagementController::class, 'index'])->name('registrations.index');
    Route::post('/registrations/{registration}/approve', [RegistrationManagementController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{registration}/reject', [RegistrationManagementController::class, 'reject'])->name('registrations.reject');
    
    // Batch Management
    Route::resource('batches', BatchController::class);
});

// Test Form Routes
Route::get('/test', [TestFormController::class, 'show'])->name('test.show');
Route::post('/test', [TestFormController::class, 'submit'])->name('test.submit');

