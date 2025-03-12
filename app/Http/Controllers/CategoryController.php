<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Конструктор с применением middleware для защиты маршрутов
     */
    public function __construct()
    {
        // Защищаем все методы, кроме index и show
        $this->middleware('auth')->except(['index', 'show']);
        // Дополнительно требуем роль учителя для create, store, edit, update, destroy
        $this->middleware('role:teacher')->except(['index', 'show']);
    }

    /**
     * Отображает список всех категорий
     */
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Отображает форму для создания новой категории
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Сохраняет новую категорию в БД
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        // Генерируем slug из названия
        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Категория успешно создана');
    }

    /**
     * Отображает детальную информацию о категории
     */
    public function show(Category $category)
    {
        // Загружаем связанные курсы, которые опубликованы
        $courses = $category->courses()->where('is_published', true)->paginate(12);

        return view('categories.show', compact('category', 'courses'));
    }

    /**
     * Отображает форму для редактирования категории
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Обновляет данные категории в БД
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Обновляем slug, если изменилось имя
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    /**
     * Удаляет категорию из БД
     */
    public function destroy(Category $category)
    {
        // Проверяем, есть ли связанные курсы
        $coursesCount = $category->courses()->count();

        if ($coursesCount > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Нельзя удалить категорию, к которой привязаны курсы (' . $coursesCount . ' шт.)');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Категория успешно удалена');
    }
}
