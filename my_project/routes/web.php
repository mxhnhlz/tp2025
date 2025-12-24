<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\Admin\AdminAnswerController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\Admin\AdminSectionController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\Admin\AdminTheoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TheoryController;
use Illuminate\Support\Facades\Route;

// Главная
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Пользовательские разделы, задачи, теории, вопросы
Route::resource('sections', SectionController::class);
Route::resource('tasks', TaskController::class);
Route::resource('theories', TheoryController::class);
Route::resource('questions', QuestionController::class);

// Регистрация
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
Route::get('/verify-email/{token}', [RegisteredUserController::class, 'verifyEmail'])->name('verify.email');

// Вход/выход
// Вход
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    // Оставляем только ОДИН маршрут для кабинета
    Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet');

    // Если вам нужно также имя 'dashboard' для обратной совместимости
    Route::get('/dashboard', [CabinetController::class, 'index'])->name('dashboard');

    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/answer', [TaskController::class, 'storeAnswer'])->name('tasks.answer');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'completeTask'])->name('tasks.complete');
    Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
});



// Админка
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('sections', AdminSectionController::class);
    Route::get('sections/{sectionId}/preview', [AdminSectionController::class, 'preview'])->name('sections.preview');

    Route::resource('tasks', AdminTaskController::class);
    Route::resource('theories', AdminTheoryController::class);
    Route::resource('questions', AdminQuestionController::class);
    Route::resource('answers', AdminAnswerController::class);
    Route::resource('users', AdminUserController::class);
});

// Вход в админку
Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/sections/{section}/tasks-json', [SectionController::class, 'tasksJson']);


