<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Показывает список всех доступных курсов
     */
    public function index()
    {
        $courses = Course::where('is_published', true)
            ->latest()
            ->paginate(12);

        return view('courses.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Показывает детальную информацию о курсе
     */
    public function show(Course $course)
    {
        // Курс должен быть опубликован, чтобы быть доступным для просмотра
        if (!$course->is_published && (auth()->guest() || auth()->user()->id !== $course->teacher_id)) {
            abort(404);
        }

        return view('courses.show', [
            'course' => $course
        ]);
    }

    /**
     * Записывает студента на курс
     */
    public function enroll(Course $course)
    {
        // Проверка, что курс опубликован
        if (!$course->is_published) {
            return redirect()->route('courses.index')->with('error', 'Курс недоступен для записи');
        }

        // Проверка, что пользователь еще не записан на курс
        if (Auth::user()->enrolledCourses->contains($course->id)) {
            return redirect()->route('student.courses')->with('info', 'Вы уже записаны на этот курс');
        }

        // Записываем пользователя на курс
        Auth::user()->enrolledCourses()->attach($course->id);

        return redirect()->route('student.courses')->with('status', 'Вы успешно записаны на курс!');
    }

    /**
     * Показывает список курсов, на которые записан студент
     */
    public function enrolledCourses()
    {
        $courses = Auth::user()->enrolledCourses()->paginate(10);

        return view('student.courses.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Показывает страницу для прохождения курса студентом
     */
    public function studyCourse(Course $course)
    {
        // Проверка, что студент записан на курс
        if (!Auth::user()->enrolledCourses->contains($course->id)) {
            return redirect()->route('student.courses')->with('error', 'Вы не записаны на этот курс');
        }

        return view('student.courses.study', [
            'course' => $course
        ]);
    }

    /**
     * Показывает список курсов преподавателя
     */
    public function teacherCourses()
    {
        $courses = Auth::user()->teacherCourses()->paginate(10);

        return view('teacher.courses.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Показывает форму создания нового курса
     */
    public function create()
    {
        return view('teacher.courses.create');
    }

    /**
     * Сохраняет новый курс в базе данных
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->slug = Str::slug($request->title) . '-' . time();
        $course->description = $request->description;
        $course->teacher_id = Auth::id();
        $course->is_published = false;

        // Обработка изображения (если загружено)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/courses'), $imageName);
            $course->image = 'images/courses/' . $imageName;
        }

        $course->save();

        return redirect()->route('teacher.courses.edit', $course)->with('status', 'Курс успешно создан!');
    }

    /**
     * Показывает форму редактирования курса
     */
    public function edit(Course $course)
    {
        // Проверка, что курс принадлежит преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('teacher.courses.edit', [
            'course' => $course
        ]);
    }

    /**
     * Обновляет данные курса
     */
    public function update(Request $request, Course $course)
    {
        // Проверка, что курс принадлежит преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->is_published = $request->has('is_published');

        // Обработка изображения (если загружено)
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если есть
            if ($course->image && file_exists(public_path($course->image))) {
                unlink(public_path($course->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/courses'), $imageName);
            $course->image = 'images/courses/' . $imageName;
        }

        $course->save();

        return redirect()->route('teacher.courses')->with('status', 'Курс успешно обновлен!');
    }

    /**
     * Показывает список студентов, записанных на курс
     */
    public function students(Course $course)
    {
        // Проверка, что курс принадлежит преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $students = $course->students()->paginate(20);

        return view('teacher.courses.students', [
            'course' => $course,
            'students' => $students
        ]);
    }
}
