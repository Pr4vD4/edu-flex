<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Получаем пользователя с загруженными отношениями
        $user = User::with('enrolledCourses')->find(Auth::id());

        // Получаем популярные курсы (используем количество студентов для сортировки)
        $popularCourses = Course::with(['teacher', 'category'])
            ->orderBy('students_count', 'desc')
            ->take(3)
            ->get();

        // Получаем новые курсы
        $newCourses = Course::with(['teacher', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Получаем категории с количеством курсов
        $categories = Category::withCount('courses')
            ->where('is_active', true)
            ->get();

        // Получаем дополнительные данные в зависимости от роли пользователя
        $userData = [];

        if ($user->role === 'teacher') {
            $userData['myCourses'] = Course::where('teacher_id', $user->id)
                ->with('category') // Загружаем связанную категорию
                ->get();
            // Используем запрос для подсчета студентов всех курсов преподавателя
            $userData['totalStudents'] = Course::where('teacher_id', $user->id)->sum('students_count');
        } elseif ($user->role === 'student') {
            // Используем eager loading для загрузки связанных данных
            $userData['enrolledCourses'] = $user->enrolledCourses()->with(['teacher', 'category'])->get();
            $userData['completedCourses'] = $user->enrolledCourses()->wherePivot('status', 'completed')->get();
        }

        return view('home', compact(
            'popularCourses',
            'newCourses',
            'categories',
            'userData'
        ));
    }
}
