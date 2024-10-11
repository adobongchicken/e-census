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
    <title>Program</title>
</head>

<body>
    <main class="flex w-full">
        <section class="w-[60%]">
            <header class="w-full flex items-center justify-between bg-blue-800 p-3">
                <div class="flex items-center gap-2">
                    <article class="relative bg-white p-2 rounded-lg">
                        <a href="/baranggay-admin/events-programs"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-6"></a>
                    </article>
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
                </div>
                <h1 class="text-white text-xl font-medium">{{ $program->program_name }}</h1>
                <article class="flex flex-col gap-3">
                    <a href="/baranggay-admin/events-programs/event/{{ $program->id }}/edit"><img src="{{ asset('assets/pencil.png') }}" alt="Edit Image" class="w-7 bg-white p-[7px] rounded-lg"></a>
                    <a href="/program/pdf/{{ $program->id }}"><img src="{{ asset('assets/download.png') }}" alt="Download Image" class="w-7 bg-white p-[7px] rounded-lg"></a>
                </article>
            </header>

            <form action="/baranggay-admin/events-programs/event/{{ $program->id }}/report"  class="flex">
                <aside class="w-[50%] p-5 flex items-start gap-5 flex-col">
                    <article class="flex items-center justify-center w-full">
                        <img src="{{ asset('event-images/' . $program->event_image) }}" alt="Uploaded Image" class="w-96 h-72 rounded-xl" id="preload-image">
                    </article>

                    <input type="text" name="event_id" value="{{ $program->id }}" hidden>

                    <article class="flex items-center w-full justify-between gap-5 lg:flex-col xl:flex-row lg:items-stretch">
                        <div class="flex-1 flex items-center gap-x-3">
                            <label class=" font-bold">Date</label>
                            <x-input-box class="input-box" type="date" value="{{ $program->date }}"/>
                        </div>
            
                        <div class="flex-1 flex items-center gap-x-3">
                            <label class=" font-bold">Time</label>
                            <x-input-box class="input-box" type="time" value="{{ $program->time }}"/>
                        </div>
                    </article>
    
                    <article class="flex flex-col items-start w-full gap-3">
                        <h1 class="font-bold">Types of Disability Groups</h1>
                        <ul class="pl-5">
                            @php
                                $eventDisabilityType = [];
                            @endphp
                            
                            @if (count(array_filter($visualImpairment)) > 0)
                                @foreach ($visualImpairment as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($learningDisabilities)) > 0)
                                @foreach ($learningDisabilities as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($hearingImpairment)) > 0)
                                @foreach ($hearingImpairment as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($speechLanguageImpairment)) > 0)
                                @foreach ($speechLanguageImpairment as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($intellectualDisabilities)) > 0)
                                @foreach ($intellectualDisabilities as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($mobilityImpairment)) > 0)
                                @foreach ($mobilityImpairment as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($psychoSocialDisabilities)) > 0)
                                @foreach ($psychoSocialDisabilities as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($multipleDisabilities)) > 0)
                                @foreach ($multipleDisabilities as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
    
                            @if (count(array_filter($otherDisabilities)) > 0)
                                @foreach ($otherDisabilities as $disability)
                                    @if (!empty($disability))
                                        @php
                                            $eventDisabilityType[] = $disability;
                                        @endphp
                                        <li class="list-disc">{{ $disability }}</li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </article>
    
                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-medium">Venue</label>
                        <x-input-box type="text" value="{{ $program->venue }}"/>
                    </article>
    
                    <article class="flex items-start flex-col w-full gap-3">
                        <button class="primary-button w-full">Report</button>
                    </article>
                </aside>
    
                <aside class="w-[50%] p-5 flex items-start gap-5 flex-col article-background">
                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-bold">Description of the Event</label>
                        <textarea cols="30" rows="10" class="border-[#e4ccff] border-2 rounded-md resize-none text-sm p-5 w-full outline-none bg-transparent">{{$program->description}}</textarea>
                    </article>

                    <article class="flex items-start flex-col w-full gap-3">
                        <label class="font-bold">Residency Requirements</label>
                        <textarea cols="30" rows="3" class="border-[#e4ccff] border-2 rounded-md resize-none text-sm p-5 w-full outline-none bg-transparent">{{$program->residency_requirements}}</textarea>
                    </article>

                    <article class="flex items-start flex-col w-full gap-3 ">
                        <label class="font-bold">Organizer</label>
                        @if (!is_null($program->organizer_name) && !is_null($program->contact_number) && !is_null($program->email))
                            <h3 class="text-xs w-full border-[#e4ccff] border-2 rounded-md p-2">{{$program->organizer_name . ' | '}} {{$program->contact_number . ' | '}} {{$program->email}}</h3> 
                        @endif   
        
                        @if (!is_null($program->organizer_name_2) && !is_null($program->contact_number_2) && !is_null($program->email_2))
                            <h3 class="text-xs w-full border-[#e4ccff] border-2 rounded-md p-2">{{$program->organizer_name_2 . ' | '}} {{$program->contact_number_2 . ' | '}} {{$program->email_2}}</h3> 
                        @endif
        
                        @if (!is_null($program->organizer_name_3) && !is_null($program->contact_number_3) && !is_null($program->email_3))
                            <h3 class="text-xs w-full border-[#e4ccff] border-2 rounded-md p-2">{{$program->organizer_name_3 . ' | '}} {{$program->contact_number_3 . ' | '}} {{$program->email_3}}</h3> 
                        @endif
                    </article>
                </aside>
            </form>
        </section>

        <section class="flex flex-col items-start flex-1 ">
            <header class="w-full flex flex-col bg-red-700 p-[10px]">
                <h1 class="text-white font-medium">List of Attendees</h1>

                <article class="flex items-center justify-between">
                    <form action="/baranggay-admin/events-programs/event/{{ $program->id }}/view" method="GET" class="relative p-2 w-fit">
                        <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                        <input type="text" class="search-box w-80 text-black font-medium" placeholder="Search person..." name="search_attending_person">
                    </form>

                    <form action="/baranggay-admin/events-programs/event/{{ $program->id }}/view" method="GET">
                        <select name="sort" class="normal-button" onchange="this.form.submit()">
                            <option selected disabled>Sort By</option>
                            <option value="id" @selected($sort === 'id')>ID</option>
                            <option value="name" @selected($sort === 'name')>Name</option>
                            <option value="baranggay" @selected($sort === 'baranggay')>Baranggay</option>
                        </select>
                    </form>
                </article>
            </header>

            <aside class="w-full p-5">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('message'))
                    <h1 class="text-sm bg-green-400 p-2 rounded-lg mb-3">{{ session('message')}} </h1>
                @endif

                <article class="flex items-center justify-center mb-5">
                    <form action="/baranggay-admin/events-programs/event/invitation" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="eventDisabilityType" value="{{ implode(', ', $eventDisabilityType) }}">
                        <input type="hidden" name="program_id" value="{{ $program->id }}">
                        <button class="primary-button bg-transparent border-2 border-gray-700 text-black">Send Invitation</button>
                    </form>
                    <button type="button" class="primary-button bg-red-600 w-56" id="cancellation-button">Cancel Program</button>
                </article>  

                <form action="/event/attendance/add" method="POST" id="attendanceForm" >
                    @csrf
                    <table class="border-collapse border border-gray-400 rounded-lg w-full">
                        <thead>
                            <tr>
                                <th class="text-sm font-bold">ID</th>
                                <th class="text-sm font-bold">Name </th>
                                <th class="text-sm font-bold">Baranggay</th>
                                <th class="text-sm font-bold">Type of Disability</th>
                                <th class="text-sm font-bold">Checklist</th>
                            </tr>
                        </thead>

                        <tbody>
                            <input type="hidden" id="person_with_disability_id" name="person_with_disability_id" >
                            <input type="hidden" id="disabilities" name="disabilities">
                            <input type="hidden" id="sex" name="sex"" >
                            <input type="hidden" id="baranggay" name="baranggay" > 

                            @foreach ($invitedPerson as $person)
                                @php
                                    $disabilities = [];
                                    $userDisability = [];
                                    
                                    $personVisualImpairment = explode(', ', $person->visual_impairment);
                                    $personLearningDisabilities = explode(', ', $person->learning_disabilities);
                                    $personHearingImpairment = explode(', ', $person->hearing_impairment);
                                    $personSpeechLanguageImpairment = explode(', ', $person->speech_language_impairment);
                                    $personIntellectualDisabilities = explode(', ', $person->intellectual_disabilities);
                                    $personMobilityImpairment = explode(', ', $person->mobility_impairment);
                                    $personPsychoSocialDisabilities = explode(', ', $person->psycho_social_disabilities);
                                    $personMultipleDisabilities = explode(', ', $person->multiple_disabilities);
                                    $personOtherDisabilities = explode(', ', $person->other_disabilities);
                            
                                    $disabilities = array_merge(
                                        array_filter($personVisualImpairment),
                                        array_filter($personLearningDisabilities),
                                        array_filter($personHearingImpairment),
                                        array_filter($personSpeechLanguageImpairment),
                                        array_filter($personIntellectualDisabilities),
                                        array_filter($personMobilityImpairment),
                                        array_filter($personPsychoSocialDisabilities),
                                        array_filter($personMultipleDisabilities),
                                        array_filter($personOtherDisabilities)
                                    );

                                    $alignedDisabilities = array_intersect($disabilities, $eventDisabilityType);
                                @endphp

                                @if (count($alignedDisabilities) > 0)
                                    <input type="hidden" name="event_id" value="{{ $program->id }}" >
                                    <input type="hidden" name="program_name" value="{{ $program->program_name }}" >
                                    <tr>
                                        <td class="text-xs text-center">{{ $person->personWithDisability->id }}</td>
                                        <td class="text-xs">{{ $person->personWithDisability->first_name}} {{$person->personWithDisability->last_name}}</td>
                                        <td class="text-xs">{{ $person->personWithDisability->present_baranggay }}</td>
                                        <td class="text-xs">
                                            @foreach ($alignedDisabilities as $disability)
                                                @php
                                                    $userDisability[] = $disability; 
                                                @endphp
                                                <p>{{ $disability }}</p>
                                            @endforeach
                                            @php
                                                $userDisabilities = implode(', ', $userDisability)
                                            @endphp
                                        </td>

                                        <td class="text-xs flex items-center border-none justify-center h-full"> 
                                            <input data-baranggay="{{ $person->personWithDisability->present_baranggay }}" data-sex="{{ $person->personWithDisability->sex }}" data-disability="{{ $userDisabilities }}" data-person-id="{{ $person->personWithDisability->id }}" type="checkbox" name="attended" class="attended-checkbox" value="present" 
                                            {{ 
                                                $person->personWithDisability->programAttendance && 
                                                $person->personWithDisability->programAttendance->program_name === $program->program_name ? 'checked disabled' : ''   
                                            }}
                                            > 
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </form>
                <article class="flex items-center justify-center gap-3 py-3">
                    {{ $invitedPerson->links()}}
                </article>             
            </aside>
            <aside class="bg-white border border-blue-700 w-1/2 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] p-5 shadow-2xl rounded-lg hidden" id="cancellation-modal">
                <form action="{{ route('cancel-program') }}" class="flex flex-col gap-5 items-start" method="POST">
                    @csrf
                    <h1 class="text-center text-2xl font-black uppercase tracking-wide w-full">Cancellation of Program</h1>
                    <h1 class="text-sm font-semibold text-center w-full">List of Person with Disabilities Invited</h1>
                    <input type="hidden" name="event_id" value="{{ $program->id }}">
                    @foreach ($invitedPerson as $person)
                        @php
                        $disabilities = [];
                            $userDisability = [];
                                    
                            $personVisualImpairment = explode(', ', $person->visual_impairment);
                            $personLearningDisabilities = explode(', ', $person->learning_disabilities);
                            $personHearingImpairment = explode(', ', $person->hearing_impairment);
                            $personSpeechLanguageImpairment = explode(', ', $person->speech_language_impairment);
                            $personIntellectualDisabilities = explode(', ', $person->intellectual_disabilities);
                            $personMobilityImpairment = explode(', ', $person->mobility_impairment);
                            $personPsychoSocialDisabilities = explode(', ', $person->psycho_social_disabilities);
                            $personMultipleDisabilities = explode(', ', $person->multiple_disabilities);
                            $personOtherDisabilities = explode(', ', $person->other_disabilities);
                            
                            $disabilities = array_merge(
                                array_filter($personVisualImpairment),
                                array_filter($personLearningDisabilities),
                                array_filter($personHearingImpairment),
                                array_filter($personSpeechLanguageImpairment),
                                array_filter($personIntellectualDisabilities),
                                array_filter($personMobilityImpairment),
                                array_filter($personPsychoSocialDisabilities),
                                array_filter($personMultipleDisabilities),
                                array_filter($personOtherDisabilities)
                            );

                            $alignedDisabilities = array_intersect($disabilities, $eventDisabilityType);
                        @endphp         
                        
                        <section class="flex items-start flex-col w-full gap-5">
                            @if (count($alignedDisabilities) > 0)
                                <input class="input-box border" type="text" name="pwd_email[]" value="{{ $person->personWithDisability->email }}" readonly>
                            @endif
                        </section>
                    @endforeach
                    <textarea name="cancellation_message" cols="30" rows="10" class="border-gray-500 border rounded-lg resize-none w-full text-xs p-3 outline-none" placeholder="Message/Reason for Cancellation..."></textarea>
                    <button class="primary-button self-center w-64">Send Email Cancellation</button>
                    <button class="primary-button self-center w-64 bg-red-700" type="button" id="back-cancellation-button">Cancel</button>
                </form>
            </aside>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const cancellationForm = document.getElementById('cancellation-modal')
            const cancellationButton = document.getElementById('cancellation-button')
            const cancelButton = document.getElementById('back-cancellation-button')

            const form = document.getElementById('attendanceForm');
            const personIdInput = document.getElementById('person_with_disability_id');
            const disability = document.getElementById('disabilities')
            const baranggay = document.getElementById('baranggay')
            const sex = document.getElementById('sex')
            
            cancellationButton.addEventListener('click', () => {
                cancellationForm.classList.remove('hidden');
            })

            cancelButton.addEventListener('click', () => {
                cancellationForm.classList.add('hidden');
            })

            document.querySelectorAll('.attended-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function(event) {
                    if (event.target.checked) {
                        const personId = event.target.getAttribute('data-person-id');
                        const personDisability = event.target.getAttribute('data-disability')
                        const personSex = event.target.getAttribute('data-sex')
                        const personBaranggay = event.target.getAttribute('data-baranggay')

                        personIdInput.value = personId;
                        disability.value = personDisability
                        sex.value = personSex
                        baranggay.value = personBaranggay

                        form.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
