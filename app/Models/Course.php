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
        'status',
        'price',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'float',
        'status' => 'string',
    ];

    /**
     * Мутатор для поля is_published - автоматически обновляет status
     */
    public function setIsPublishedAttribute($value)
    {
        $this->attributes['is_published'] = $value;

        // Если is_published меняется, синхронизируем status
        if ($value) {
            $this->attributes['status'] = 'published';
        } elseif (isset($this->attributes['status']) && $this->attributes['status'] === 'published') {
            $this->attributes['status'] = 'draft';
        }
    }

    /**
     * Мутатор для поля status - автоматически обновляет is_published
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;

        // Если status меняется, синхронизируем is_published
        $this->attributes['is_published'] = ($value === 'published');
    }

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

    /**
     * Категория курса
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
