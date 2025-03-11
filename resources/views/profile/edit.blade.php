@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Редактирование профиля</h1>

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <form method="POST" action="{{ route('profile.update') }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Имя</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Сохранить изменения
                        </button>
                        <a href="{{ route('profile') }}" class="text-blue-600 hover:text-blue-800">
                            Отмена
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Смена пароля</h2>
                    <p class="text-sm text-gray-600 mt-1">Здесь вы можете изменить пароль для доступа к вашей учетной записи.</p>
                </div>
                <div class="p-6">
                    <a href="{{ route('profile.password') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                        Изменить пароль
                    </a>
                </div>
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
