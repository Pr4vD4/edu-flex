<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Test;

class TestController extends Controller
{
    /**
     * Показать тест для прохождения
     */
    public function show(Course $course, Test $test)
    {
        // Проверка, что студент записан на курс
        if (!auth()->user()->enrolledCourses->contains($course->id)) {
            return redirect()->route('student.courses')->with('error', 'Вы не записаны на этот курс');
        }

        // Проверка, что тест принадлежит курсу
        if ($test->course_id !== $course->id) {
            abort(404);
        }

        return view('student.tests.show', [
            'course' => $course,
            'test' => $test,
        ]);
    }

    /**
     * Отправка ответов на тест
     */
    public function submit(Request $request, Course $course, Test $test)
    {
        // Проверка, что студент записан на курс
        if (!auth()->user()->enrolledCourses->contains($course->id)) {
            return redirect()->route('student.courses')->with('error', 'Вы не записаны на этот курс');
        }

        // Проверка, что тест принадлежит курсу
        if ($test->course_id !== $course->id) {
            abort(404);
        }

        // Валидация данных
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ]);

        // Обработка ответов (заглушка)
        // TODO: Реализовать проверку ответов и сохранение результатов

        return redirect()->route('student.courses.study', $course)->with('status', 'Тест успешно пройден!');
    }
}
