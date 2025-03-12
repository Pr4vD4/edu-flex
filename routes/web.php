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
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CategoryController;

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
    Route::get('/courses', [CourseController::class, 'teacherCourses'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'teacherShow'])->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/courses/{course}/publish', [CourseController::class, 'publish'])->name('courses.publish');
    Route::post('/courses/{course}/unpublish', [CourseController::class, 'unpublish'])->name('courses.unpublish');

    // Маршруты для управления уроками курса
    Route::get('/courses/{course}/lessons', [LessonController::class, 'index'])->name('courses.lessons.index');
    Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('courses.lessons.create');
    Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])->name('courses.lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('courses.lessons.show');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('courses.lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('courses.lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('courses.lessons.destroy');
    Route::post('/courses/{course}/lessons/{lesson}/move', [LessonController::class, 'move'])->name('courses.lessons.move');
    Route::delete('/courses/{course}/lessons/{lesson}/attachments/{attachment}', [LessonController::class, 'deleteAttachment'])->name('courses.lessons.attachments.destroy');

    // Маршруты для управления студентами курсов
    Route::get('/courses/{course}/students', [CourseController::class, 'students'])->name('courses.students');

    // Маршруты для управления категориями (доступны для преподавателей)
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
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

// Маршруты для категорий
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Маршруты для управления категориями (доступны только для админа)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
