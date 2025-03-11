@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="py-4 px-6 bg-blue-600 text-white text-center">
                <h2 class="text-2xl font-bold">Сброс пароля</h2>
            </div>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 mx-6" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="py-6 px-8">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Отправить ссылку для сброса пароля
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-gray-600 text-sm">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-bold">Вернуться к форме входа</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
