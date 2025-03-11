<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ auth()->check() ? route('home') : route('welcome') }}" class="text-blue-600 font-bold text-xl flex items-center">
                    <img src="{{ asset('img/icons/book.svg') }}" alt="Logo" class="h-8 w-8 mr-2">
                    EduFlex
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-1" x-data="{ open: false }">
                <a href="{{ auth()->check() ? route('home') : route('welcome') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">Главная</a>
                <a href="{{ route('courses.index') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">Курсы</a>
                <a href="#" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">Преподаватели</a>
                <a href="#" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">Блог</a>
                <a href="#" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">О нас</a>
            </nav>

            <!-- Search -->
            <div class="hidden md:flex-1 md:flex md:items-center md:justify-center max-w-lg mx-4">
                <div class="relative w-full">
                    <input type="text" placeholder="Поиск курсов..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    <img src="{{ asset('img/icons/search.svg') }}" alt="Search" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5">
                </div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center">
                <div class="relative" x-data="{ open: false }">
                    @guest
                        <div class="flex space-x-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition">Войти</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Регистрация</a>
                        </div>
                    @else
                        <button @click="open = !open" class="flex items-center text-gray-700 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover">
                            <span class="ml-2 font-medium hidden md:block">{{ auth()->user()->name }}</span>
                            <img src="{{ asset('img/icons/chevron-down.svg') }}" alt="Dropdown" class="h-5 w-5 ml-1">
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl py-1"
                             style="display: none; z-index: 200;">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Мой профиль
                            </a>
                            <a href="{{ route('student.courses') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Мои курсы
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Выйти
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden ml-2" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-md text-gray-700 hover:text-blue-600 focus:outline-none">
                        <img x-show="!open" src="{{ asset('img/icons/menu.svg') }}" alt="Menu" class="h-6 w-6">
                        <img x-show="open" src="{{ asset('img/icons/close.svg') }}" alt="Close" class="h-6 w-6">
                    </button>

                    <!-- Mobile Menu -->
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition
                         class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center"
                         style="display: none; z-index: 200;">
                        <div class="bg-white w-4/5 max-w-sm rounded-lg p-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Меню</h3>
                                <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                                    <img src="{{ asset('img/icons/close.svg') }}" alt="Close" class="h-6 w-6">
                                </button>
                            </div>

                            <div class="space-y-2">
                                <a href="{{ auth()->check() ? route('home') : route('welcome') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Главная</a>
                                <a href="{{ route('courses.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Курсы</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Преподаватели</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Блог</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">О нас</a>

                                <div class="border-t border-gray-200 my-2"></div>

                                @guest
                                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Войти</a>
                                    <a href="{{ route('register') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">Регистрация</a>
                                @else
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Мой профиль</a>
                                    <a href="{{ route('student.courses') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Мои курсы</a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Выйти</button>
                                    </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
