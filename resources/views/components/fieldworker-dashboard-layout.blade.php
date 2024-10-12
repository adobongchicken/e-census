@props(['title'])
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    <title>{{ $title }}</title>
</head>

<body class="h-full flex">
    <!-- Sidebar -->
    <!-- Sidebar -->
    <nav id="sidebar"
        class="bg-white border-r border-red-300 h-screen w-30 transition-transform duration-300 ease-in-out"
        :class="{ '-translate-x-full': !sidebarOpen }">
        <div class="flex items-center gap-x-2 px-4 mb-4"> <!-- Changed gap-x-4 to gap-x-2 -->
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-16">
            <h1 class="font-bold text-xl">Dashboard</h1>
        </div>
        
        <article class="flex flex-col w-full overflow-y-auto">
            <x-nav-link href="/fieldworker/register-residents" :active="request()->is('fieldworker/register-residents')">Register Residents</x-nav-link>
            <x-nav-link href="/fieldworker/events-programs" :active="request()->is('fieldworker/events-programs')">Events and Program</x-nav-link>
            @if (request()->is('fieldworker/events-programs*'))
                <a  href="/fieldworker/events-programs/birthday-cash-gifts" class="w-[80%] self-end rounded-md  border-red-700 border p-2 py-3 text-center cursor-pointer text-sm font-medium {{ request()->is('fieldworker/events-programs/birthday-cash-gifts*') ? 'bg-red-600 text-white' : '' }} ">Birthday Cash Gifts</a>
                <a  href="/fieldworker/events-programs/scholarship" class="w-[80%] self-end rounded-md  border-red-700 border p-2 py-3 text-center cursor-pointer text-sm font-medium {{ request()->is('fieldworker/events-programs/scholarship') ? 'bg-red-600 text-white' : '' }} ">PWD Student Scholarship</a>
            @endif
        </article>

        <article id="logout-button" class="w-full mt-8 p-3 border-2 border-gray-600 flex items-center justify-between cursor-pointer">
            <h1 class="flex items-center justify-center gap-x-3 text-sm">
                <img src="{{ asset('assets/user.png') }}" alt="Username" class="w-4">
                @if (auth()->user())
                    <span>{{ auth()->user()->username }}</span>
                @endif
            </h1>
            <img src="{{ asset('assets/angle-small-down.png') }}" alt="Drop Down Logo" class="w-4">
        </article>
        <article class="self-end hidden" id="logout-section">
            <form action="/auth/logout" method="POST">
                @csrf
                <button class="border-2 border-gray-600 text-xs p-1 rounded-sm font-medium px-3">Logout</button>
            </form>
        </article>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-4 overflow-y-auto">
        <button id="hamburger" class="p-2 text-gray-600 lg:hidden">
            <i class="fas fa-bars"></i> <!-- Hamburger icon -->
        </button>
        {{ $slot }}
    </main>

    <script>
        const logoutButton = document.getElementById('logout-button');
        const logoutSection = document.getElementById('logout-section');
        const toggleButton = document.getElementById('toggle-button');
        const sidebar = document.getElementById('sidebar');
        const hamburgerButton = document.getElementById('hamburger');

        // Toggle logout section visibility
        logoutButton.addEventListener('click', () => {
            logoutSection.classList.toggle('hidden');
        });

        // Toggle sidebar visibility on close button click
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Show sidebar when hamburger button is clicked
        hamburgerButton.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });
    </script>
</body>

</html>
