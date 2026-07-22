<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Public\ResourceController;
use Illuminate\Support\Facades\Route;

// ============================================================
//  PUBLIC — no login required
// ============================================================
Route::get('/', [ResourceController::class, 'index'])->name('welcome');
Route::get('/search', [ResourceController::class, 'search'])->name('search');

// ============================================================
//  BROWSE — students and librarians only
// ============================================================
Route::middleware(['student.access'])->group(function () {
    Route::get('/browse/{classLevel}', [ResourceController::class, 'showClassLevel'])
         ->name('browse.class-level');
    Route::get('/browse/{classLevel}/{subject}', [ResourceController::class, 'showSubject'])
         ->name('browse.subject');
    Route::get('/browse/{classLevel}/{subject}/{topic}', [ResourceController::class, 'showTopic'])
         ->name('browse.topic');
});

// ============================================================
//  BREEZE /dashboard → our admin dashboard
// ============================================================
Route::get('/dashboard', [AdminDashboardController::class, 'index'])
     ->middleware(['auth', 'librarian.only'])
     ->name('dashboard');

// ============================================================
//  ADMIN PORTAL — librarians only (auth + role check)
// ============================================================
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', 'librarian.only'])
     ->group(function () {

         Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

         // Class Levels
         Route::get('/class-levels', [AdminDashboardController::class, 'classLevels'])->name('class-levels');
         Route::post('/class-levels', [AdminDashboardController::class, 'storeClassLevel'])->name('class-levels.store');
         Route::put('/class-levels/{classLevel}', [AdminDashboardController::class, 'updateClassLevel'])->name('class-levels.update');
         Route::delete('/class-levels/{classLevel}', [AdminDashboardController::class, 'destroyClassLevel'])->name('class-levels.destroy');

         // Subjects
         Route::get('/subjects', [AdminDashboardController::class, 'subjects'])->name('subjects');
         Route::post('/subjects', [AdminDashboardController::class, 'storeSubject'])->name('subjects.store');
         Route::put('/subjects/{subject}', [AdminDashboardController::class, 'updateSubject'])->name('subjects.update');
         Route::delete('/subjects/{subject}', [AdminDashboardController::class, 'destroySubject'])->name('subjects.destroy');

         // Topics
         Route::get('/topics', [AdminDashboardController::class, 'topics'])->name('topics');
         Route::post('/topics', [AdminDashboardController::class, 'storeTopic'])->name('topics.store');
         Route::put('/topics/{topic}', [AdminDashboardController::class, 'updateTopic'])->name('topics.update');
         Route::delete('/topics/{topic}', [AdminDashboardController::class, 'destroyTopic'])->name('topics.destroy');

         // Resources
         Route::get('/resources', [AdminDashboardController::class, 'resources'])->name('resources');
         Route::post('/resources', [AdminDashboardController::class, 'storeResource'])->name('resources.store');
         Route::put('/resources/{resource}', [AdminDashboardController::class, 'updateResource'])->name('resources.update');
         Route::delete('/resources/{resource}', [AdminDashboardController::class, 'destroyResource'])->name('resources.destroy');
         Route::patch('/resources/{resource}/toggle-verify', [AdminDashboardController::class, 'toggleVerify'])->name('resources.toggle-verify');

         // Students
         Route::get('/students', [AdminDashboardController::class, 'students'])->name('students');
         Route::post('/students', [AdminDashboardController::class, 'storeStudent'])->name('students.store');
         Route::delete('/students/{user}', [AdminDashboardController::class, 'destroyStudent'])->name('students.destroy');
         Route::patch('/students/{user}/reset-password', [AdminDashboardController::class, 'resetStudentPassword'])->name('students.reset-password');
     });

require __DIR__.'/auth.php';