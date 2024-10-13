<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <title> {{ $program->program_name }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>

    <header class="flex items-center justify-between p-3 bg-blue-800">
        <div class="flex items-center gap-2">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard/events-programs"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-5"></a>
            </article>
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
        </div>
        <h1 class="text-white text-xl font-medium">{{ $program->program_name }}</h1>
        
        <a href="/program/report/{{ $program->id }}"><img src="{{ asset('assets/download.png') }}" alt="Download Image" class="w-7 bg-white p-[7px] rounded-lg cursor-pointer"></a>
    </header>
    <section class="w-full p-7 flex flex-col gap-5">
        <article class="flex items-center justify-center w-full">
            <img src="{{ asset('event-images/' . $program->event_image) }}" alt="Uploaded Image" class="w-96 h-72 rounded-xl" id="preload-image">
        </article>

        <article class="flex items-center justify-between w-full">
            <h1 class="font-bold text-[16px]">Attendees Report</h1>
            <div class="flex items-center gap-x-3">
                <h1 class="font-bold text-[16px]">Number of Attendees</h1>
                <p class="border-2 border-red-700 px-2 rounded-lg">{{ $personAttended->count() }}</p>
            </div>
        </article>

        <aside class="flex items-start gap-x-5 h-full">
            <article class="p-6 rounded shadow w-64 border-2 border-red-700 h-[365px] flex-1">
                {!! $sexChart->container() !!}
            </article>

            <article class="p-6 rounded shadow border-2 border-red-700 flex items-start justify-center h-[365px] flex-1">
                {!! $disabilitiesChart->container() !!}
            </article>

            <article class="p-6 rounded shadow border-2 border-red-700 h-[365px] flex-1">
                {!! $baranggayChart->container() !!}
            </article>
        </aside>
</section>

    <script src="{{ $sexChart->cdn() }}"></script>
    <script src="{{ $disabilitiesChart->cdn() }}"></script>
    <script src="{{ $baranggayChart->cdn() }}"></script>

    {{ $sexChart->script() }}
    {{ $disabilitiesChart->script() }}
    {{ $baranggayChart->script() }}
</body>
</html>