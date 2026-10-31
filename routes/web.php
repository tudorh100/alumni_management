<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\alumni\alumniController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\HomeController;

// Public home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Registration
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Login
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Logout: ONE route only, outside the admin/user groups, so both admins and alumni can use it
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ---------------------------------------------------------------------
// Admin routes
// ---------------------------------------------------------------------
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [adminController::class, 'index'])
        ->name('admin.dashboard');

    // Departments
    Route::get('/admin/createdepartment', [adminController::class, 'add_department'])
        ->name('admin.createdepartment');

    Route::post('/admin/store-department', [adminController::class, 'store_department'])
        ->name('admin.store_department');

    Route::get('/admin/department', [adminController::class, 'department'])
        ->name('admin.department');

    // Alumni
    Route::get('/admin/showalumni', [adminController::class, 'showalumni'])
        ->name('admin.showalumni');

    Route::delete('/admin/alumni/{profile}', [adminController::class, 'destroy_alumni'])
        ->name('admin.alumni.destroy');

    // Announcements
    Route::get('/admin/add-announcement', [adminController::class, 'addAnnouncement'])
        ->name('admin.addAnnouncement');

    Route::post('/admin/add-announcement', [adminController::class, 'storeAnnouncement'])
                ->name('admin.storeAnnouncement');

    Route::get('/admin/announcement/{announcement}/edit', [adminController::class, 'editAnnouncement'])
    ->name('admin.editAnnouncement');

    Route::put('/admin/announcements/{announcement}', [adminController::class, 'updateAnnouncement'])
    ->name('admin.updateAnnouncement');

    Route::delete('/admin/announcements/{announcement}', [adminController::class, 'destroyAnnouncement'])
    ->name('admin.destroyAnnouncement');

    // EXPORT TO PDF
    Route::get('/admin/alumni/export-pdf', [adminController::class, 'exportAlumniPdf'])
        ->name('admin.alumni.export.pdf');

  

});


// ---------------------------------------------------------------------
// Alumni (user) routes
// ---------------------------------------------------------------------
Route::middleware(['auth', 'user'])->group(function () {

    Route::get('/alumni/dashboard', [alumniController::class, 'index'])
        ->name('alumni.dashboard');

    // Add profile
    Route::get('/alumni/profile', [alumniController::class, 'addprofile'])
        ->name('alumni.profile');

    Route::post('/alumni/profile', [alumniController::class, 'store_profile'])
        ->name('alumni.profile.store');

    // View profile
    Route::get('/alumni/showprofile', [alumniController::class, 'showprofile'])
        ->name('alumni.show_alumni_profile');

    // Edit profile
    Route::get('/alumni/profile/edit', [alumniController::class, 'edit_profile'])
        ->name('alumni.edit_profile');

    Route::put('/alumni/profile', [alumniController::class, 'update_profile'])
        ->name('alumni.profile.update');

    // Announcements
    Route::get('/alumni/viewAnnouncements', [alumniController::class, 'viewAnnouncement'])
        ->name('alumni.viewAnnouncement');

    // The resource routes below were removed: they only point to empty stub methods
    // and add extra public-looking URLs such as /alumni/create and /alumni/{id}/edit.
    // Route::resource('alumni', alumniController::class)->except(['index']);
});