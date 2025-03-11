<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * Урок, к которому прикреплен файл
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}