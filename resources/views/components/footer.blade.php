<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-4">О EduFlex</h3>
                <p class="text-gray-400">Образовательная платформа с широким выбором курсов для профессионального и личностного развития.</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Быстрые ссылки</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Главная</a></li>
                    <li><a href="{{ route('courses.index') }}" class="text-gray-400 hover:text-white transition">Курсы</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Преподаватели</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Блог</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">О нас</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Контакты</h3>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <img src="{{ asset('img/icons/mail.svg') }}" alt="Email" class="h-5 w-5 mr-2 mt-0.5">
                        <span class="text-gray-400">info@eduflex.com</span>
                    </li>
                    <li class="flex items-start">
                        <img src="{{ asset('img/icons/phone.svg') }}" alt="Phone" class="h-5 w-5 mr-2 mt-0.5">
                        <span class="text-gray-400">+7 (123) 456-78-90</span>
                    </li>
                    <li class="flex items-start">
                        <img src="{{ asset('img/icons/location.svg') }}" alt="Location" class="h-5 w-5 mr-2 mt-0.5">
                        <span class="text-gray-400">г. Москва, ул. Образовательная, д. 42</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Следите за нами</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <img src="{{ asset('img/icons/twitter.svg') }}" alt="Twitter" class="h-6 w-6">
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <img src="{{ asset('img/icons/instagram.svg') }}" alt="Instagram" class="h-6 w-6">
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <img src="{{ asset('img/icons/facebook.svg') }}" alt="Facebook" class="h-6 w-6">
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <img src="{{ asset('img/icons/linkedin.svg') }}" alt="LinkedIn" class="h-6 w-6">
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-700 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} EduFlex. Все права защищены.</p>
        </div>
    </div>
</footer>
