@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-gray-100 py-16 min-h-[80vh] flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-md shadow-lg overflow-hidden">
            <div class="py-5 px-6 bg-blue-700 text-white text-center">
                <h2 class="text-2xl font-bold">Вход в систему</h2>
                <p class="text-blue-100 mt-1">Добро пожаловать в EduFlex</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="py-8 px-8">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            class="pl-10 shadow-sm appearance-none border rounded-md w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="pl-10 shadow-sm appearance-none border rounded-md w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-gray-700">
                            Запомнить меня
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-md focus:outline-none focus:shadow-outline">
                        Войти
                    </button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="inline-block align-baseline font-bold text-sm text-blue-700 hover:text-blue-900">
                            Забыли пароль?
                        </a>
                    @endif
                </div>

                <div class="text-center mt-6 border-t pt-6">
                    <p class="text-gray-600 text-sm">
                        Нет аккаунта? <a href="{{ route('register') }}" class="text-blue-700 hover:text-blue-900 font-bold">Зарегистрируйтесь</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
