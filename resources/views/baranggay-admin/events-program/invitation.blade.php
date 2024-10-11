<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title>Program Invitation</title>
</head>

<body class="invitation-background">
    <form action="/baranggay-admin/events-programs/event/invitation/sending" method="POST">
        @csrf
        @method('POST')
        <header class="flex items-center justify-between bg-blue-800 p-3">
            <div class="flex items-center gap-2">
                <article class="relative bg-white p-2 rounded-lg">
                    <a href="{{ url()->previous() }}"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-6"></a>
                </article>
                <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
            </div>
            <h1 class=" text-white text-lg font-medium text-end w-[30%]">{{ $program->program_name }} </h1>
            <input type="hidden" name="program_name" value="{{ $program->program_name }}">
            <input type="hidden" name="disabilities" value="{{ implode(', ', $eventDisabilityType)}}">
            <input type="email" class="input-box w-72" name="pwd_email" placeholder="Enter PWD email address." required>
        </header>

        <main class="w-full flex flex-col pb-10">
            <section class="w-full p-4 flex">
                <aside class="w-1/2 flex flex-col gap-5">
                    <article class="flex items-center justify-center w-full">
                        <img src="{{ asset('event-images/' . $program->event_image) }}" alt="Uploaded Image" class="w-96 h-72 rounded-xl" id="preload-image">
                    </article>

                    <article class="flex items-center w-full justify-between gap-x-5 ">
                        <div class="flex-1 flex items-center gap-x-3">
                            <label class="font-bold">Date</label>
                            <x-input-box class="bg-transparent" name="date" type="date" value="{{ $program->date }}" />
                        </div>

                        <div class="flex-1 flex items-center gap-x-3">
                            <label class="font-bold">Time</label>
                            <x-input-box class="bg-transparent" name="time" type="time" value="{{ $program->time }}" />
                        </div>
                    </article>

                    <article class="flex flex-col items-start w-full gap-3">
                        <h1 class="font-bold">Types of Disability</h1>
                        <ul class="pl-5">
                            @foreach ($eventDisabilityType as $disability)
                                <li class="list-disc text-sm font-medium"> {{ $disability }} </li>
                            @endforeach
                        </ul>
                    </article>

                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-medium">Location</label>
                        <x-input-box type="text" name="location" value="{{ $program->location }}" class="bg-transparent" />
                    </article>

                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-medium">Venue</label>
                        <x-input-box type="text" name="venue" value="{{ $program->venue }}" class="bg-transparent" />
                    </article>
                </aside>

                <aside class="w-[50%] p-5 flex items-start gap-5 flex-col">
                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-bold">Description of the Event</label>
                        <textarea name="description" cols="30" rows="10" class="border-[#e4ccff] border-2 rounded-md resize-none text-sm p-5 w-full outline-none bg-transparent">{{ $program->description }}</textarea>
                    </article>

                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-bold">Residency Requirements</label>
                        <textarea name="residency_requirements" cols="30" rows="3" class="border-[#e4ccff] border-2 rounded-md resize-none text-sm p-5 w-full outline-none bg-transparent">{{ $program->residency_requirements }}</textarea>
                    </article>

                    <article class="flex items-start flex-col w-full gap-3 ">
                        <label class="font-bold">Organizer</label>
                        @if (!is_null($program->organizer_name) && !is_null($program->contact_number) && !is_null($program->email))
                            <h3 class="text-xs w-full border-[#e4ccff] border-2 rounded-md p-2"> {{ $program->organizer_name . ' | ' }} {{ $program->contact_number . ' | ' }} {{ $program->email }}</h3>
                            <input type="hidden" name="organizer_name" value="{{ $program->organizer_name }}">
                            <input type="hidden" name="contact_number" value="{{ $program->contact_number }}">
                            <input type="hidden" name="email" value="{{ $program->email }}">
                        @endif

                        @if (!is_null($program->organizer_name_2) && !is_null($program->contact_number_2) && !is_null($program->email_2))
                            <h3 class="text-xs w-full border-[#e4ccff] border-2 rounded-md p-2">{{ $program->organizer_name_2 . ' | ' }} {{ $program->contact_number_2 . ' | ' }} {{ $program->email_2 }}</h3>
                            <input type="hidden" name="organizer_name_2" value="{{ $program->organizer_name_2 }}">
                            <input type="hidden" name="contact_number_2" value="{{ $program->contact_number_2 }}">
                            <input type="hidden" name="email_2" value="{{ $program->email_2 }}">
                        @endif

                        @if (!is_null($program->organizer_name_3) && !is_null($program->contact_number_3) && !is_null($program->email_3))
                            <h3 class="text-xs w-full border-[#e4ccff] border-2 rounded-md p-2"> {{ $program->organizer_name_3 . ' | ' }} {{ $program->contact_number_3 . ' | ' }} {{ $program->email_3 }}</h3>

                            <input type="hidden" name="organizer_name_3" value="{{ $program->organizer_name_3 }}">
                            <input type="hidden" name="contact_number_3" value="{{ $program->contact_number_3 }}">
                            <input type="hidden" name="email_3" value="{{ $program->email_3 }}">
                        @endif
                    </article>
                </aside>
            </section>
            <button class="primary-button w-72 self-center">Send Invitation</button>
        </main>
    </form>
</body>

</html>
