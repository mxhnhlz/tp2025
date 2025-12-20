<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\Admin\AdminSectionController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\Admin\AdminTheoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TheoryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('home');
});

Route::resource('sections', SectionController::class);
Route::resource('tasks', TaskController::class);
Route::resource('theories', TheoryController::class);
Route::resource('questions', QuestionController::class);

// Админка
Route::middleware('admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('sections', AdminSectionController::class);
        Route::get('sections/{sectionId}/preview', [AdminSectionController::class, 'preview'])->name('sections.preview');
        Route::resource('tasks', AdminTaskController::class);
        Route::resource('theories', AdminTheoryController::class);
        Route::resource('questions', AdminQuestionController::class);
        Route::resource('answers', AdminAnswerController::class);
        Route::resource('users', AdminUserController::class);

    });

// Регистрация
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');


// Вход
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Выход
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/cabinet', function () {
        return view('dashboard');
    })->name('dashboard');
});


// auth
Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
