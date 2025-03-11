@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Панель студента</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-indigo-50 p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-500 text-white mr-4">
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

                    <div class="bg-yellow-50 p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold">Пройдено курсов</div>
                                <div class="text-3xl font-bold">0</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-semibold">Сертификаты</div>
                                <div class="text-3xl font-bold">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Мои курсы</h2>
                    <div class="bg-white overflow-hidden border border-gray-200 sm:rounded-lg">
                        <div class="px-4 py-8 text-center text-gray-500">
                            Вы пока не записаны ни на один курс.
                        </div>
                        <div class="px-4 py-4 border-t border-gray-200 flex justify-center">
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                                Найти курсы
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Прогресс обучения</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <h3 class="font-medium text-gray-900 mb-2">Активность</h3>
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-3 h-3 bg-gray-200 rounded-full"></div>
                            </div>
                            <p class="text-sm text-gray-500">Нет данных о вашей активности за последнюю неделю.</p>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                            <h3 class="font-medium text-gray-900 mb-2">Ближайшие дедлайны</h3>
                            <p class="text-sm text-gray-500">У вас пока нет предстоящих дедлайнов.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
