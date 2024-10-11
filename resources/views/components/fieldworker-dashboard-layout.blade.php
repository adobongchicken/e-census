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

<body class="h-full flex items-start">
    <nav class="flex items-start flex-col border-2 border-red-700 w-80 rounded-md h-full py-5">
        <div class="flex items-center gap-x-4 px-4 mb-4">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-16">
            <h1 class="font-bold text-xl">Dashboard</h1>
        </div>
        <article class="flex flex-col w-full">
            <x-nav-link href="/fieldworker/register-residents" :active="request()->is('fieldworker/register-residents')">Register Residents</x-nav-link>
            <x-nav-link href="/fieldworker/events-programs" :active="request()->is('fieldworker/events-programs')">Events and Program</x-nav-link>
        </article>

        <article id="logout-button"
            class="w-full mt-8 p-3 border-2 border-gray-600 flex items-center justify-between cursor-pointer">
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
    <main class="w-full">
        {{ $slot }}
    </main>
    <script>
        const logoutButton = document.getElementById('logout-button')
        const logoutSection = document.getElementById('logout-section')

        logoutButton.addEventListener('click', () => {
            logoutSection.classList.toggle('hidden')
        })
    </script>
</body>

</html>
