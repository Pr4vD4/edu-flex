<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'teacher_id',
        'is_published',
        'price',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'float',
    ];

    /**
     * Преподаватель курса
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Студенты, записанные на курс
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')
            ->withPivot('progress', 'status')
            ->withTimestamps();
    }

    /**
     * Уроки курса
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    /**
     * Модули курса
     */
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('position');
    }

    /**
     * Тесты курса
     */
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    /**
     * Записи на курс
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Сертификаты, выданные за курс
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
