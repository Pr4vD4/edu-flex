<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Конструктор, применяющий middleware для защиты маршрутов
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    /**
     * Отображает список уроков курса
     */
    public function index(Course $course)
    {
        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $lessons = $course->lessons()->orderBy('position')->get();

        return view('teacher.lessons.index', [
            'course' => $course,
            'lessons' => $lessons
        ]);
    }

    /**
     * Отображает форму создания нового урока
     */
    public function create(Course $course)
    {
        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('teacher.lessons.create', [
            'course' => $course
        ]);
    }

    /**
     * Сохраняет новый урок в базе данных
     */
    public function store(Request $request, Course $course)
    {
        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'position' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);

        // Определение позиции, если не указана
        if (!isset($validated['position'])) {
            $lastPosition = $course->lessons()->max('position') ?? 0;
            $validated['position'] = $lastPosition + 1;
        }

        // Установка публикации
        $validated['is_published'] = $request->has('is_published');

        // Создание урока
        $lesson = new Lesson($validated);
        $lesson->course_id = $course->id;
        $lesson->save();

        // Обработка прикрепленных файлов
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lesson-attachments', 'public');

                $attachment = new LessonAttachment([
                    'lesson_id' => $lesson->id,
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);

                $attachment->save();
            }
        }

        return redirect()->route('teacher.courses.lessons.index', $course)
            ->with('status', 'Урок успешно создан!');
    }

    /**
     * Отображает форму редактирования урока
     */
    public function edit(Course $course, Lesson $lesson)
    {
        // Проверка, что урок принадлежит курсу
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('teacher.lessons.edit', [
            'course' => $course,
            'lesson' => $lesson
        ]);
    }

    /**
     * Обновляет данные урока
     */
    public function update(Request $request, Course $course, Lesson $lesson)
    {
        // Проверка, что урок принадлежит курсу
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'position' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);

        // Установка публикации
        $validated['is_published'] = $request->has('is_published');

        $lesson->update($validated);

        // Обработка прикрепленных файлов
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lesson-attachments', 'public');

                $attachment = new LessonAttachment([
                    'lesson_id' => $lesson->id,
                    'title' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);

                $attachment->save();
            }
        }

        return redirect()->route('teacher.courses.lessons.index', $course)
            ->with('status', 'Урок успешно обновлен!');
    }

    /**
     * Удаляет прикрепленный файл
     */
    public function deleteAttachment(Course $course, Lesson $lesson, LessonAttachment $attachment)
    {
        // Проверка, что урок принадлежит курсу
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Проверка, что файл принадлежит уроку
        if ($attachment->lesson_id !== $lesson->id) {
            abort(404);
        }

        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Удаляем файл с сервера
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // Удаляем запись из базы
        $attachment->delete();

        return redirect()->route('teacher.courses.lessons.edit', [$course, $lesson])
            ->with('status', 'Файл успешно удален!');
    }

    /**
     * Удаляет урок
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        // Проверка, что урок принадлежит курсу
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Удаляем прикрепленные файлы
        foreach ($lesson->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            $attachment->delete();
        }

        // Удаляем урок
        $lesson->delete();

        return redirect()->route('teacher.courses.lessons.index', $course)
            ->with('status', 'Урок успешно удален!');
    }

    /**
     * Отображает детальную информацию об уроке
     */
    public function show(Course $course, Lesson $lesson)
    {
        // Проверка, что урок принадлежит курсу
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Загружаем прикрепленные файлы
        $lesson->load('attachments');

        // Находим предыдущий и следующий уроки
        $lessons = $course->lessons()->orderBy('position')->get();
        $currentIndex = $lessons->search(function($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        $prevLesson = ($currentIndex > 0) ? $lessons[$currentIndex - 1] : null;
        $nextLesson = ($currentIndex < $lessons->count() - 1) ? $lessons[$currentIndex + 1] : null;

        return view('teacher.lessons.show', [
            'course' => $course,
            'lesson' => $lesson,
            'prevLesson' => $prevLesson,
            'nextLesson' => $nextLesson
        ]);
    }

    /**
     * Изменяет позицию урока (вверх или вниз)
     */
    public function move(Request $request, Course $course, Lesson $lesson)
    {
        // Проверка, что урок принадлежит курсу
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Проверка, что курс принадлежит текущему преподавателю
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'direction' => 'required|in:up,down',
        ]);

        $direction = $request->input('direction');
        $currentPosition = $lesson->position;

        if ($direction === 'up' && $currentPosition > 1) {
            // Находим урок выше текущего
            $upperLesson = Lesson::where('course_id', $course->id)
                ->where('position', $currentPosition - 1)
                ->first();

            if ($upperLesson) {
                $upperLesson->position = $currentPosition;
                $upperLesson->save();

                $lesson->position = $currentPosition - 1;
                $lesson->save();
            }
        } elseif ($direction === 'down') {
            // Находим урок ниже текущего
            $lowerLesson = Lesson::where('course_id', $course->id)
                ->where('position', $currentPosition + 1)
                ->first();

            if ($lowerLesson) {
                $lowerLesson->position = $currentPosition;
                $lowerLesson->save();

                $lesson->position = $currentPosition + 1;
                $lesson->save();
            }
        }

        return redirect()->route('teacher.courses.lessons.index', $course);
    }
}
