@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="py-4 px-6 bg-blue-600 text-white text-center">
                <h2 class="text-2xl font-bold">Вход в систему</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="py-6 px-8">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">

                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                            class="mr-2 leading-tight">
                        <label for="remember" class="text-sm text-gray-700">
                            Запомнить меня
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Войти
                    </button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                            Забыли пароль?
                        </a>
                    @endif
                </div>

                <div class="text-center mt-4">
                    <p class="text-gray-600 text-sm">
                        Нет аккаунта? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-bold">Зарегистрироваться</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
