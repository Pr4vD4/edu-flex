@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Панель преподавателя</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-blue-50 p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold">Мои курсы</div>
                                <div class="text-3xl font-bold">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold">Студенты</div>
                                <div class="text-3xl font-bold">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold">Тесты</div>
                                <div class="text-3xl font-bold">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Мои курсы</h2>
                    <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg">
                        <div class="px-4 py-8 text-center text-gray-500">
                            У вас пока нет созданных курсов. Начните с создания вашего первого курса!
                        </div>
                        <div class="px-4 py-4 border-t border-gray-200 flex justify-center">
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Создать курс
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Последняя активность</h2>
                    <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg">
                        <div class="px-4 py-8 text-center text-gray-500">
                            Пока нет активности для отображения.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
