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

        // Получаем популярные курсы
        $popularCourses = Course::where('status', 'published')
            ->orderBy('students_count', 'desc')
            ->take(6)
            ->get();

        // Получаем новые курсы
        $newCourses = Course::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Получаем категории с количеством курсов
        $categories = Category::withCount('courses')
            ->where('is_active', true)
            ->get();

        // Получаем дополнительные данные в зависимости от роли пользователя
        $userData = [];

        if ($user->role === 'teacher') {
            $userData['myCourses'] = Course::where('teacher_id', $user->id)->get();
            $userData['totalStudents'] = Course::where('teacher_id', $user->id)->sum('students_count');
        } elseif ($user->role === 'student') {
            $userData['enrolledCourses'] = $user->enrolledCourses;
            $userData['completedCourses'] = $user->enrolledCourses->where('pivot.status', 'completed');
        }

        return view('home', compact(
            'popularCourses',
            'newCourses',
            'categories',
            'userData'
        ));
    }
}
