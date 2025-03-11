<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'position',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Курс, к которому принадлежит модуль
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Уроки модуля
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }
}
