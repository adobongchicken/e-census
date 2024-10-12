@props(['title'])
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMl8z5B3v6P1kF1mZ4m2HZqDYPn7HtG2I2Z5r0" crossorigin="anonymous">
    <title>{{ $title }}</title>
</head>

<body class="h-full flex">
    <!-- Sidebar -->
    <nav id="sidebar" class="bg-white border-r border-gray-300 h-screen w-60 fixed top-0 left-0 z-50"> 
        <!-- Sidebar content -->
        <div class="flex items-center gap-x-2 px-4 mb-4">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-16">
            <h1 class="font-bold text-xl">Dashboard</h1>
            <button id="toggle-button" class="p-2 text-gray-600 lg:hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex-grow overflow-y-auto">
            <article class="flex flex-col w-full">
                <x-nav-link href="/super-admin/dashboard" :active="request()->is('super-admin/dashboard') || request()->is('super-admin/dashboard/sort')">Barangay and Reports</x-nav-link>
                <x-nav-link href="/super-admin/dashboard/accounts" :active="request()->is('super-admin/dashboard/accounts') || request()->is('super-admin/dashboard/accounts/sort')">Accounts</x-nav-link>
                <x-nav-link href="/super-admin/dashboard/events-programs" :active="request()->is('super-admin/dashboard/events-programs')">Events and Programs</x-nav-link>
            </article>
        </div>

        <article id="logout-button" class="w-full mt-8 p-3 border-2 border-red-600 flex items-center justify-between cursor-pointer">
            <h1 class="flex items-center justify-center gap-x-3 text-sm">
                <img src="{{ asset('assets/user.png') }}" alt="Username" class="w-4">
                @if (auth()->user())
                    <span>{{ auth()->user()->username }}</span>
                @endif
            </h1>
            <img src="{{ asset('assets/angle-small-down.png') }}" alt="Drop Down Logo" class="w-4">
        </article>
        <article class="self-end hidden" id="logout-section">
            <a href="/administrator/change-password/{{ auth()->user()->id }}" class="border-2 border-gray-600 text-xs p-1 rounded-sm font-medium px-3">Change Password</a>
            <form action="/auth/logout" method="POST">
                @csrf
                <button class="border-2 border-gray-600 text-xs p-1 rounded-sm font-medium px-3">Logout</button>
            </form>
        </article>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-4 overflow-y-auto ml-64"> 
        <!-- Added margin-left to offset sidebar width -->
        <button id="hamburger" class="p-2 text-gray-600 lg:hidden">
            <i class="fas fa-bars"></i>
        </button>
        {{ $slot }}
    </main>

    <script>
        const toggleButton = document.getElementById('toggle-button');
        const sidebar = document.getElementById('sidebar');
        const hamburgerButton = document.getElementById('hamburger');
        let sidebarOpen = true;

        // Toggle sidebar on close button click
        toggleButton.addEventListener('click', () => {
            sidebarOpen = !sidebarOpen;
            sidebar.classList.toggle('-translate-x-full', !sidebarOpen);
        });

        // Show sidebar when hamburger button is clicked
        hamburgerButton.addEventListener('click', () => {
            sidebarOpen = true;
            sidebar.classList.remove('-translate-x-full');
        });

        const logoutButton = document.getElementById('logout-button');
        const logoutSection = document.getElementById('logout-section');

        logoutButton.addEventListener('click', () => {
            logoutSection.classList.toggle('hidden');
        });
    </script>
</body>

</html>
