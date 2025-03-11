<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
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

        return view('home', compact('popularCourses', 'newCourses', 'categories'));
    }
}
