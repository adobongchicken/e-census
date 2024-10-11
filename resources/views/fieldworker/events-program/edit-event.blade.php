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
    <title>Edit Event</title>
</head>

<body>
    <header class="w-full bg-red-700 p-4 flex items-center">
        <div class="flex items-center gap-2">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="{{ url()->previous() }}"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-8"></a>
            </article>
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
        </div>
        <h1 class="text-center text-white text-xl font-medium w-full">Edit Program</h1>
    </header>
 
    <form method="POST" action="/field-worker/event/update/{{ $event->id }}" class="p-5 px-32" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="flex flex-col gap-10 program-form">
            <article class="flex flex-col items-center">
                <img alt="Uploaded Image" class="w-96 h-96 rounded-xl hidden" id="preload-image">
    
                <div class="w-full">
                    <button id="uploadButton" type="button" class="primary-button bg-transparent border-blue-700 border-2 text-black">Upload Photo</button>
                </div>
                <input type="file" name="event_image" accept=".png, .jpeg, .jpg" hidden id="input_file"/>
            </article>
    
            <article class="flex items-center">
                <label class="w-64 font-bold">Program Name</label>
                <x-input-box class="input-box" type="text" name="program_name" value="{{ old('program_name', $event->program_name) }}" />
            </article>

            <article class="flex items-center">
                <label class="w-64 font-bold">Location</label>
                <x-input-box class="input-box" type="text" name="location" value="{{ old('location', $event->location) }}"/>
            </article>
            
            <article class="flex items-center">
                <label class="w-64 font-bold">Venue</label>
                <x-input-box class="input-box" type="text" name="venue" value="{{ old('venue', $event->venue) }}"/>
            </article>
    
            <article class="flex items-center w-full justify-between gap-x-5 ">
                <div class="flex-1 flex items-center gap-x-3">
                    <label class=" font-bold">Date</label>
                    <x-input-box class="input-box" type="date" name="date" value="{{ old('date', $event->date) }}"/>
                </div>
    
                <div class="flex-1 flex items-center gap-x-3">
                    <label class=" font-bold">Time</label>
                    <x-input-box class="input-box" type="time" name="time" value="{{ old('time', $event->time) }}"/>
                </div>

                <div class="flex-1 flex items-center gap-x-3">
                    <label class=" font-bold">Duration</label>
                    <x-input-box class="input-box" type="number" name="duration" placeholder="By hour/s" value="{{ old('duration', $event->duration) }}"/>
                </div>
            </article>
    
            <article class="flex items-start flex-col gap-2">
                <label class="w-64 font-bold">Description</label>
                <textarea name="description" cols="30" rows="10" class="input-box border-red-700">{{ old('description', $event->program_name) }}</textarea>
            </article>
    
            <article class="flex items-start flex-col gap-2">
                <label class="w-64 font-bold">Residency Requirements</label>
                <textarea name="residency_requirements" cols="30" rows="10" class="input-box border-red-700">{{ old('residency_requirements', $event->residency_requirements) }}</textarea>
            </article>

            <h1 class="font-bold">Disability Type</h1>

            <section class="flex items-center justify-start w-full">

                <article class="flex flex-col gap-2 items-start justify-start w-[40%]">
                    <h1 class="font-bold text-sm">Visual Impairment</h1>
                    <div class="flex items-center gap-1">
                    <input type="checkbox" name="visual_impairment[]" value="Blindness" @checked(in_array('Blindness', $disabilities))>
                        <label class="text-sm font-medium">Blindness</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="visual_impairment[]" value="Low Vision" @checked(in_array('Low Vision', $disabilities))>
                        <label class="text-sm font-medium">Low Vision</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[35%] items-start justify-start">
                    <h1 class="font-bold text-sm">Speech/Language Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="speech_language_impairment[]" value="Difficulty Speaking" @checked(in_array('Difficuly Speaking', $disabilities))>
                        <label class="text-xs font-medium">Difficulty Speaking (Stuttering, Dysarthria)</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="speech_language_impairment[]" value="Non-verbal" @checked(in_array('Non-verbal', $disabilities))>
                        <label class="text-sm font-medium">Non-verbal</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 items-start justify-start">
                    <h1 class="font-bold text-sm">Learning Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="Dyslexia" @checked(in_array('Dyslexia', $disabilities))>
                        <label class="text-sm font-medium">Dyslexia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="ADHD" @checked(in_array('ADHD', $disabilities))>
                        <label class="text-sm font-medium">ADHD</label>
                    </div>
                </article>
            </section>

            <section class="flex items-center justify-start w-full">
                <article class="flex flex-col gap-2 w-[40%]">
                    <h1 class="font-bold text-sm">Hearing Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="hearing_impairment[]" value="Blindness" @checked(in_array('Blindness', $disabilities))>
                        <label class="text-sm font-medium">Blindness</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="hearing_impairment[]" value="Low Vision" @checked(in_array('Low Vision', $disabilities))>
                        <label class="text-sm font-medium">Low Vision</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[35%]">
                    <h1 class="font-bold text-sm">Intellectual Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Down Syndrome" @checked(in_array('Down Syndrome', $disabilities))>
                        <label class="text-sm font-medium">Down Syndrome</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Development Delay" @checked(in_array('Development Delay', $disabilities))>
                        <label class="text-sm font-medium">Development Delay</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Autism Spectrum Disorder" @checked(in_array('Autism Spectrum Disorder', $disabilities))>
                        <label class="text-sm font-medium">Autism Spectrum Disorder</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Learning Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="Dyslexia" @checked(in_array('Dyslexia', $disabilities))>
                        <label class="text-sm font-medium">Dyslexia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="ADHD" @checked(in_array('ADHD', $disabilities))>
                        <label class="text-sm font-medium">ADHD</label>
                    </div>
                </article>
            </section>

            <section class="flex items-center justify-start w-full">
                <article class="flex flex-col gap-2 w-[40%]">
                    <h1 class="font-bold text-sm">Mobility Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Paraplegia" @checked(in_array('Paraplegia', $disabilities))>
                        <label class="text-sm font-medium">Paraplegia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Quadriplegia" @checked(in_array('Quadriplegia', $disabilities))>
                        <label class="text-sm font-medium">Quadriplegia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Amputation" @checked(in_array('Amputation', $disabilities))>
                        <label class="text-sm font-medium">Amputation</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Musculoskeletal Disabilities" @checked(in_array('Musculoskeletal Disabilities', $disabilities))>
                        <label class="text-sm font-medium text-wrap w-1/2">Musculoskeletal Disabilities</label>
                    </div>                    
                </article>

                <article class="flex flex-col gap-2 w-[35%]">
                    <h1 class="font-bold text-sm">Psycho Social Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Depression" @checked(in_array('Depression', $disabilities))>
                        <label class="text-sm font-medium">Depression</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Anxiety Disorder" @checked(in_array('Anxiety Disorder', $disabilities))>
                        <label class="text-sm font-medium">Anxiety Disorder</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Schizophrenia" @checked(in_array('Schizophrenia', $disabilities))>
                        <label class="text-sm font-medium">Schizophrenia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Bipolar Disorder" @checked(in_array('Bipolar Disorder', $disabilities))>
                        <label class="text-sm font-medium">Bipolar Disorder</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Multiple Disabilities (different categories)</h1>
                    @if (count($multipleDisabilities) > 0)
                        @foreach ($multipleDisabilities as $disability)
                            <div class="flex items-center gap-1">
                                <label class="text-sm font-medium">Specify: </label>
                                <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1" value="{{ $disability }}">
                            </div>
                        @endforeach
                    @endif
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1" >
                    </div>
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1" >
                    </div>
                    <h1 class="font-bold text-sm">Other Disability</h1>
                    @if (count($otherDisabilities) > 0)
                        @foreach ($multipleDisabilities as $disability)
                            <div class="flex items-center gap-1">
                                <label class="text-sm font-medium">Specify: </label>
                                <input type="text" name="other_disabilities[]" class="border-b border-black outline-none text-xs p-1" value="{{ $disability }}">
                            </div>
                        @endforeach
                    @endif
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="other_disabilities[]" class="border-b border-black outline-none text-xs p-1" >
                    </div>
                </article>
            </section>
            <button class="primary-button bg-red-700 self-center w-64" type="button" id="next">Next</button>
        </section>

        <section class="flex flex-col gap-10 organizer-form hidden">
            <article class="flex items-start flex-col gap-3">
                <label class="font-bold text-sm uppercase">Organizer's Name</label>
                <x-input-box class="input-box" type="text" name="organizer_name" value="{{ old('organizer_name', $event->organizer_name) }}"/>
            </article>

            <article class="flex items-start flex-col gap-5">
                <h1 class="font-bold uppercase text-sm">Contact Information</h1>

                <aside class="flex items-center justify-around w-full gap-x-10">
                    <div class="flex-1 flex gap-2 flex-col">
                        <label class="font-medium text-sm text-center">Contact Number</label>
                        <x-input-box class="input-box" type="text" name="contact_number" value="{{ old('contact_number', $event->contact_number) }}"/>
                    </div>

                    <div class="flex-1 flex gap-2 flex-col">
                        <label class="font-medium text-sm text-center">Email Address</label>
                        <x-input-box class="input-box" type="email" name="email" value="{{ old('email', $event->email) }}"/>
                    </div>
                </aside>
            </article>

            <article class="flex items-start flex-col gap-3">
                <label class="font-bold text-sm uppercase">Organizer's Name 2</label>
                <x-input-box class="input-box" type="text" name="organizer_name_2" value="{{ old('organizer_name_2', $event->organizer_name_2) }}" />
            </article>

            <article class="flex items-start flex-col gap-5">
                <h1 class="font-bold uppercase text-sm">Contact Information 2</h1>

                <aside class="flex items-center justify-around w-full gap-x-10">
                    <div class="flex-1 flex gap-2 flex-col">
                        <label class="font-medium text-sm text-center">Contact Number</label>
                        <x-input-box class="input-box" type="text" name="contact_number_2" value="{{ old('contact_number_2', $event->contact_number_2) }}"/>
                    </div>

                    <div class="flex-1 flex gap-2 flex-col">
                        <label class="font-medium text-sm text-center">Email Address</label>
                        <x-input-box class="input-box" type="email" name="email_2" value="{{ old('email_2', $event->email_2) }}"/>
                    </div>
                </aside>
            </article>

            <article class="flex items-start flex-col gap-3">
                <label class="font-bold text-sm uppercase">Organizer's Name 3</label>
                <x-input-box class="input-box" type="text" name="organizer_name_3" value="{{ old('organizer_name_3', $event->organizer_name_3) }}" />
            </article>

            <article class="flex items-start flex-col gap-5">
                <h1 class="font-bold uppercase text-sm">Contact Information 3</h1>

                <aside class="flex items-center justify-around w-full gap-x-10">
                    <div class="flex-1 flex gap-2 flex-col">
                        <label class="font-medium text-sm text-center">Contact Number</label>
                        <x-input-box class="input-box" type="text" name="contact_number_3" value="{{ old('contact_number_3', $event->contact_number_3) }}" />
                    </div>

                    <div class="flex-1 flex gap-2 flex-col">
                        <label class="font-medium text-sm text-center">Email Address</label>
                        <x-input-box class="input-box" type="email" name="email_3" value="{{ old('email_3', $event->email_3) }}"/>
                    </div>
                </aside>
            </article>
            <button class="primary-button bg-red-700 w-64 self-center">Save</button>
        </section>
    </form>
    <script>
        const uploadButton = document.getElementById('uploadButton')
        const inputFileBox = document.getElementById('input_file')
        const displayImage = document.getElementById('preload-image')
        const nextButton = document.getElementById('next')
        const orgForm = document.querySelector('.organizer-form')
        const progForm = document.querySelector('.program-form')
        const timeInput = document.querySelector('input[name="time"]');

        uploadButton.addEventListener('click', () => {
            inputFileBox.click()
        })

        inputFileBox.addEventListener('change', (event) => {

            const file = event.target.files[0]

            if(!file) return

            const readFile = new FileReader()

            readFile.onload = (event) => {
                displayImage.src = `${event.target.result}`;
                displayImage.classList.remove('hidden')
            }
            readFile.readAsDataURL(file);
        })

        nextButton.addEventListener('click', () => {
            progForm.classList.add('hidden')
            orgForm.classList.remove('hidden')
            
        })

    </script>
</body>

</html>
