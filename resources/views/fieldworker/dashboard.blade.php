<x-fieldworker-dashboard-layout>
    <x-slot:title>Register Residents</x-slot:title>

    <header class="w-full sticky top-0 left-0 z-10">
        <article class="w-full bg-red-600 flex items-center justify-between px-2 pr-10 p-3">
            <div>
                <h1 class="text-white text-lg font-medium">Register Residents</h1>
            </div>

            <div class="bg-white p-2 rounded-lg overflow-hidden">
                    <div id="notification-button"><img src="{{ asset('assets/notification.png') }}" alt="Notification Image" class="w-5 cursor-pointer "></div>
            </div>
        </article>

        <aside class="bg-blue-800 p-3 flex items-center justify-between border-2 border-blue-950 rounded-md">
            <h1 class="text-white text-lg font-medium text-end w-[60%]">List of Residents with Disabilities</h1>
            <article>
                <a href="/fieldworker/register-residents/pwd/create" class="normal-button">Add PWD <span class="font-semibold">+</span></a>
                <a href="/people-list-within-baranggay-with-disability/pdf/{{ auth()->user()->baranggay_id }}" class="normal-button">Download List</a>
            </article>
        </aside>

        <article class="flex items-center justify-center absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] w-[100%] z-10 hidden" id="notification-modal">
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
                    <button class="primary-button bg-red-700" id="close-notification">Close</button>
                </section>
            </main>
        </article>
        
        <aside class="flex items-center justify-end bg-[#0d99ff] p-3 gap-3"> 
            <form action="{{ route('fieldworker-dashboard') }}" method="GET" class="relative p-2 w-fit">
                <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                <input type="text" class="search-box w-80" placeholder="Search person..." name="search_person">
            </form>

            <form action="{{ route('fieldworker-dashboard') }}">
                <select name="sort_disability_type" class="normal-button" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By Disablity Type --</option>
                    <option value="">All</option>
                    <option value="Visual Impairment" @selected($sortedDisability === 'Visual Impairment')>Visual Impairment</option>
                    <option value="Hearing Impairment" @selected($sortedDisability === 'Hearing Impairment')>Hearing Impairment</option>
                    <option value="Learning Disabilities" @selected($sortedDisability === 'Learning Disabilities')>Learning Disabilities</option>
                    <option value="Speech and Language Impairment" @selected($sortedDisability === 'Speech and Language Impairment')>Speech and Language Impairment</option>
                    <option value="Intellectual Disabilities" @selected($sortedDisability === 'Intellectual Disabilities')>Intellectual Disabilities</option>
                    <option value="Mobility Impairment" @selected($sortedDisability === 'Mobility Impairment')>Mobility Impairment</option>
                    <option value="Psycho-Social Disabilities" @selected($sortedDisability === 'Psycho-Social Disabilities')>Psycho-Social Disabilities</option>
                    <option value="Multiple Disabilities" @selected($sortedDisability === 'Multiple Disabilities')>Multiple Disabilities</option>
                    <option value="Other Disabilities" @selected($sortedDisability === 'Other Disabilities')>Other Disabilities</option>
                </select>
            </form>

            <form action="{{ route('fieldworker-dashboard') }}">
                <select name="sort_status" class="normal-button" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By Status --</option>
                    <option value="">All</option>
                    <option value="Active" @selected($sortedByStatus === 'Active')>Active</option>
                    <option value="Moved" @selected($sortedByStatus === 'Moved')>Moved</option>
                    <option value="Deceased" @selected($sortedByStatus === 'Deceased')>Deceased</option>
                </select>
            </form>

            <form action="{{ route('fieldworker-dashboard') }}">
                <select name="sort" class="normal-button" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By --</option>
                    <option>All</option>
                    <option value="id" @selected($sort === 'id')>ID</option>
                    <option value="name" @selected($sort === 'name')>Name</option>
                    <option value="assisted" @selected($sort === 'assisted')>Assisted</option>
                </select>
            </form>
        </aside>
    </header>
    @if (session('message'))
            <h1 class="text-sm font-medium w-full px-5 bg-green-500 py-3 text-white rounded-lg mt-2">{{ session('message') }}</h1>
        @endif
    <section class="p-10">
        
        <table class="border-collapse border border-gray-400 rounded-lg w-full">
            <thead>
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Person with Disabilities</th>
                    <th class="text-sm font-bold">Status</th>
                    <th class="text-sm font-bold">Type of Disabilities</th>
                    <th class="text-sm font-bold">Assisted By</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($persons as $person)
                        @php
                            $visualImpairment = explode(', ', $person->disabilityType->visual_impairment);
                            $learningDisabilities = explode(', ', $person->disabilityType->learning_disabilities);
                            $hearingImpairment = explode(', ', $person->disabilityType->hearing_impairment);
                            $speechLanguageImpairment = explode(', ', $person->disabilityType->speech_language_impairment);
                            $intellectualDisabilities = explode(', ', $person->disabilityType->intellectual_disabilities);
                            $mobilityImpairment = explode(', ', $person->disabilityType->mobility_impairment);
                            $psychoSocialDisabilities = explode(', ', $person->disabilityType->psycho_social_disabilities);
                            $multipleDisabilities = explode(', ', $person->disabilityType->multiple_disabilities);
                            $otherDisabilities = explode(', ', $person->disabilityType->other_disabilities);
                        @endphp

                        <tr>
                            <td class="text-center">{{ $person->id}}</td>
                            <td class="text-center">{{ $person->first_name }} {{ $person->last_name }}</td>
                            <td class="text-center">{{ $person->submittedForm->status }}</td>
                            <td class="text-center">
                               @php
                                    $allDisabilities = array_merge(
                                        $visualImpairment,
                                        $learningDisabilities,
                                        $hearingImpairment,
                                        $speechLanguageImpairment,
                                        $intellectualDisabilities,
                                        $mobilityImpairment,
                                        $psychoSocialDisabilities,
                                        $multipleDisabilities,
                                        $otherDisabilities
                                    );
                                    $allDisabilities = array_filter($allDisabilities); 
                                @endphp
                                {{ implode(', ', $allDisabilities) }}
                            </td>
                            <td class="text-center">
                                {{ $person->submittedForm->assisted_by}}
                            </td>
                            <td>
                                <div class="flex items-center justify-center gap-x-3">
                                    <a href="/fieldworker/register-residents/{{ $person->id }}/edit"><img src="{{ asset('assets/pencil.png')}}" alt="Edit Image" class="w-5"></a>
                                    <form action="/fieldworker/register-residents/{{ $person->id }}/delete" method="POST" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="flex items-center justify-center"><img src="{{ asset('assets/trash.png')}}" alt="Delete Image" class="w-5"></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach         
            </tbody>
        </table>
        <article class="flex items-center justify-center gap-3 py-3">
            {{ $persons->links()}}
        </article>
    </section>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this person? This action cannot be undone.');
        }
        const notificationButton = document.getElementById('notification-button')
        const notificationModal = document.getElementById('notification-modal')
        const closeNotification = document.getElementById('close-notification')

        notificationButton.addEventListener('click', () => {
            notificationModal.classList.remove('hidden')
        })

        closeNotification.addEventListener('click', () => {
            notificationModal.classList.add('hidden')
        })
    </script>
</x-fieldworker-dashboard-layout>