<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Синхронизация существующих записей
        // 1. Обновляем status на 'published' для всех курсов, где is_published = true
        DB::statement('UPDATE courses SET status = "published" WHERE is_published = true AND status != "published"');

        // 2. Обновляем status на 'draft' для всех курсов, где is_published = false
        DB::statement('UPDATE courses SET status = "draft" WHERE is_published = false AND status = "published"');

        // 3. Обновляем is_published на true для всех курсов, где status = 'published'
        DB::statement('UPDATE courses SET is_published = true WHERE status = "published" AND is_published = false');

        // 4. Обновляем is_published на false для всех курсов, где status != 'published'
        DB::statement('UPDATE courses SET is_published = false WHERE status != "published" AND is_published = true');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Миграция только синхронизирует данные, ничего не создает/удаляет
    }
};
