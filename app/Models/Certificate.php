<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'issue_date',
        'certificate_number',
        'path',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
    ];

    /**
     * Пользователь, которому принадлежит сертификат
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Курс, за который выдан сертификат
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
