@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Изменение пароля</h1>

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <form method="POST" action="{{ route('profile.password.update') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Текущий пароль</label>
                        <input id="current_password" type="password" name="current_password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Новый пароль</label>
                        <input id="password" type="password" name="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Подтверждение пароля</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Изменить пароль
                        </button>
                        <a href="{{ route('profile') }}" class="text-blue-600 hover:text-blue-800">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('profile') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; Вернуться к профилю
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
