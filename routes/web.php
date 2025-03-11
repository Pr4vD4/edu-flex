<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Главная страница для гостей
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Главная страница для авторизованных пользователей
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// Маршруты для курсов
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// Запись на курс (требуется авторизация)
Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])
    ->middleware('auth')
    ->name('courses.enroll');

// Маршруты аутентификации
Route::middleware('guest')->group(function () {
    // Авторизация
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Регистрация
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Восстановление пароля
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Выход из системы
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Маршруты для преподавателя
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('dashboard');

    // Маршруты управления курсами преподавателя
    Route::get('/courses', [CourseController::class, 'teacherCourses'])->name('courses');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');

    // Маршруты для управления студентами курсов
    Route::get('/courses/{course}/students', [CourseController::class, 'students'])->name('courses.students');
});

// Маршруты для студента
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('dashboard');

    // Маршруты для управления записанными курсами
    Route::get('/courses', [CourseController::class, 'enrolledCourses'])->name('courses');
    Route::get('/courses/{course}', [CourseController::class, 'studyCourse'])->name('courses.study');

    // Маршруты для прохождения тестов
    Route::get('/courses/{course}/tests/{test}', [TestController::class, 'show'])->name('tests.show');
    Route::post('/courses/{course}/tests/{test}', [TestController::class, 'submit'])->name('tests.submit');

    // Маршруты для сертификатов
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates');
    Route::get('/certificates/{certificate}', [CertificateController::class, 'download'])->name('certificates.download');
});

// Профиль пользователя (доступен всем авторизованным)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
