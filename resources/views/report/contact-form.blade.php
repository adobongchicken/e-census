<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <title>Contact Person</title>
</head>
<body class="h-full">
    <section class="flex items-center justify-center h-full">
        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('sendSMS') }}" method="POST" class="w-1/2 flex flex-col gap-3 border rounded-lg p-10 border-blue-700">
            @csrf
            <h1 class="w-full text-center font-bold text-2xl">Contact Participants</h1>
            <input type="hidden" name="program_name" value="{{ $event->program_name }}">
            <input type="hidden" name="date" value="{{ $event->date }}">
            <input type="hidden" name="time" value="{{ $event->time }}">
            <input type="hidden" name="location" value="{{ $event->location }}">
            <input type="hidden" name="venue" value="{{ $event->venue }}">
            <input type="hidden" name="description" value="{{ $event->description }}">
            <input type="hidden" name="duration" value="{{ $event->duration }}">

            <article class="flex flex-col gap-2">
                <label class="text-sm font-semibold">Person With Disabilities Contact Number</label>
                <input type="number" class="input-box" name="pwd_phone_number" value="{{ $person->contact_no }}" >
            </article>

            <article class="flex flex-col gap-2">
                <label class="text-sm font-semibold">Guardian Contact Number</label>
                <input type="number" class="input-box" name="guardian_phone_number" value="{{ $person->guardians->guardian_phone_number }}" readonly>
            </article>
            <button class="primary-button">Send SMS</button>
        </form>
    </section>
</body>
</html>