<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Программирование',
                'description' => 'Курсы по программированию и разработке программного обеспечения',
            ],
            [
                'name' => 'Дизайн',
                'description' => 'Курсы по графическому дизайну, веб-дизайну и UX/UI',
            ],
            [
                'name' => 'Маркетинг',
                'description' => 'Курсы по маркетингу, рекламе и продвижению',
            ],
            [
                'name' => 'Бизнес',
                'description' => 'Курсы по предпринимательству и управлению бизнесом',
            ],
            [
                'name' => 'Наука о данных',
                'description' => 'Курсы по анализу данных, машинному обучению и искусственному интеллекту',
            ],
            [
                'name' => 'Иностранные языки',
                'description' => 'Курсы по изучению иностранных языков',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
