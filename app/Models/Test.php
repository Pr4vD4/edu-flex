<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'duration_minutes',
        'passing_score',
        'is_published',
    ];

    /**
     * Курс, к которому принадлежит тест
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Вопросы теста
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Результаты тестов студентов
     */
    public function results()
    {
        return $this->hasMany(TestResult::class);
    }
}
