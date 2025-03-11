<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Показать форму авторизации
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Обработка авторизации
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Перенаправление в зависимости от роли
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isTeacher()) {
                return redirect()->intended(route('teacher.dashboard'));
            } else {
                return redirect()->intended(route('home'));
            }
        }

        return back()->withErrors([
            'email' => 'Предоставленные учетные данные не соответствуют нашим записям.',
        ])->onlyInput('email');
    }

    /**
     * Выход из системы
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
