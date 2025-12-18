<div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/5 relative">

    <!-- BUTTON MENU (KIRI) -->
    <button type="button" class="text-lg text-gray-600">
        <svg class="mr-2 w-5 h-5" fill="none" stroke-width="1.5" stroke="currentColor"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5">
            </path>
        </svg>
    </button>

    <!-- TITLE -->
    <ul class="flex items-center">
        <li>
            <p class="text-gray-400">@yield('nav-title')</p>
        </li>
    </ul>

    <!-- KANAN ATAS (LOGO + DROPDOWN) -->
    <ul class="ml-auto flex items-center relative">
        <li class="relative">

            <!-- LOGO BUTTON -->
            <button id="profileDropdownButton" type="button"
                class="mt-2 ml-2 focus:outline-none">
                <img src="/images/logo2.png" alt="Profile"
                    class="w-8 h-8 rounded-full border border-gray-200 hover:ring-2 hover:ring-blue-500 transition">
            </button>

            <!-- DROPDOWN -->
            <div id="profileDropdownMenu"
                class="hidden absolute right-0 mt-3 w-52 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

                <!-- HEADER DROPDOWN -->
                <div class="flex flex-col items-center px-4 py-4 border-b border-gray-200">
                    <img src="/images/logo2.png" alt="Logo"
                        class="w-12 h-12 mb-2 rounded-full">
                    {{-- <p class="text-sm font-semibold text-gray-700">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </p> --}}
                    <p class="text-xs text-gray-400">
                        {{ auth()->user()->role ?? 'Administrator' }}
                    </p>
                </div>

                <a href="{{ route('logout') }}"
                onclick="return confirm('Apakah Anda yakin ingin logout?')"
                class="block w-full px-4 py-3 text-sm text-red-600 text-center 
                        hover:!bg-red-600 hover:!text-white
                        transition-all duration-200 rounded-b-lg">
                Logout
                </a>


            </div>
        </li>
    </ul>
</div>

<!-- SCRIPT DROPDOWN -->
<script>
    const btn = document.getElementById('profileDropdownButton');
    const menu = document.getElementById('profileDropdownMenu');

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        menu.classList.add('hidden');
    });
</script>
