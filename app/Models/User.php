<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
            ->withPivot('progress', 'status')
            ->withTimestamps();
    }

    /**
     * Сертификаты пользователя
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Проверяет, является ли пользователь администратором
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Проверяет, является ли пользователь преподавателем
     *
     * @return bool
     */
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    /**
     * Проверяет, является ли пользователь студентом
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
}
