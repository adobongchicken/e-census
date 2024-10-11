<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <title>Notification</title>
</head>

<body class="h-screen flex items-center justify-center">
    <main class="w-1/2 bg-[#e4ccff]">
        <header class="bg-blue-800 p-5 rounded-md">
            <h1 class="text-white text-lg text-center">Notifications</h1>
        </header>
        <section class="p-3 flex flex-col gap-5">
            @if ($events->count() > 0)
                @foreach ($events as $event)
                    <article class="flex flex-col gap-1 {{ $events->count() > 1 ? 'border-b border-red-700 pb-3' : ''}} ">
                        <div class="flex items-center justify-between">
                            <h1 class="font-bold text-sm">Program Name: <span class="text-xs font-medium">{{ $event->program_name }}</span></h1>
                            <p class="text-xs font-medium">{{ \Carbon\Carbon::parse($event->time)->format('F j, Y') }}</p>
                        </div>
                        <h1 class="font-bold text-sm">Venue: <span class="text-xs font-medium">{{ $event->venue }}</span></h1>
                        <h1 class="font-bold text-sm">Location: <span class="text-xs font-medium">{{ $event->location }}</span></h1>
                    </article>
                @endforeach
            @else
                <h1 class="text-lg font-semibold tracking-wide">No events</h1>
            @endif
            <a href="{{ $back }}" class="primary-button text-center text-sm">Back</a>
        </section>
    </main>
</body>
</html>
