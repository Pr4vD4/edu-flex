<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Показывает профиль пользователя
     */
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Показывает форму редактирования профиля
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Обновляет данные профиля пользователя
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return redirect()->route('profile')->with('status', 'Профиль успешно обновлен!');
    }

    /**
     * Показывает форму изменения пароля
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Обновляет пароль пользователя
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('status', 'Пароль успешно обновлен!');
    }
}
