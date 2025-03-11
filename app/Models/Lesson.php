<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'course_id',
        'position',
        'is_published',
        'duration_minutes',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'position' => 'integer',
        'duration_minutes' => 'integer',
    ];

    /**
     * Курс, к которому принадлежит урок
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Прикрепленные файлы к уроку
     */
    public function attachments()
    {
        return $this->hasMany(LessonAttachment::class);
    }
}
