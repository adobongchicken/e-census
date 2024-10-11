<x-dashboard-layout>
    <x-slot:title>Events and Programs</x-slot:title>
    
    <header class="w-full bg-blue-800 p-3 flex items-center justify-between">
        <article class="flex items-center gap-x-3">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
            <h1 class="text-white text-xl font-medium">Events and Programs</h1>
        </article>

        <article class="bg-white p-2 rounded-lg overflow-hidden">
            <div id="notification-button"><img src="{{ asset('assets/notification.png') }}" alt="Notification Image" class="w-5 cursor-pointer "></div>
        </article>
    </header>

    <article class="flex items-center justify-center absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] w-[100%] z-10 hidden" id="notification-modal">
        <main class="w-1/2 bg-[#e4ccff]">
            <header class="bg-blue-800 p-5 rounded-md">
                <h1 class="text-white text-lg text-center">Notifications</h1>
            </header>
            <section class="p-3 flex flex-col gap-5">
                @if ($todayEvent->count() > 0)
                    @foreach ($todayEvent as $event)
                        <article class="flex flex-col gap-1 {{ $todayEvent->count() > 1 ? 'border-b border-red-700 pb-3' : ''}} ">
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

    <article class="px-3">
        @if (session('message'))
            <h1 class="text-sm font-medium w-full px-5 bg-green-500 py-3 text-white rounded-lg my-2">{{ session('message') }}</h1>
        @endif
    </article>
    <main class="flex items-start">
        <section class="w-[53%] py-5 flex flex-col gap-3 px-10">
            <article class="w-full flex items-center justify-end">
                <a href="/super-admin/dashboard/events-programs/create-event"
                    class="flex items-center justify-center normal-button shadow-lg border border-gray-300 gap-x-2 font-medium py-1">Add
                    Event <span class="font-bold text-lg">+</span>
                </a>
            </article>
            <div id="calendar"></div>
        </section>

        <section class="flex-1">
            <aside class="w-full bg-red-700 p-4 flex items-center justify-between">
                <h1 class="text-white font-medium text-xl">Programs</h1>
                <article class="flex items-center gap-x-2">
                    <form action="{{ route('event-dashboard') }}" method="GET" class="relative p-2 w-fit">
                        @csrf
                        <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                        <input type="text" class="search-box w-40 text-black font-medium" placeholder="Search events..." name="search_event">
                    </form>

                    <form action="{{ route('event-dashboard') }}" method="GET">
                        <select name="sort" class="normal-button py-1" onchange="this.form.submit()">
                            <option selected disabled>-- Sort By --</option>
                            <option value="program_name" @selected( $sort === 'program_name')>Program Name</option>
                            <option value="location" @selected( $sort === 'location')>Location</option>
                            <option value="date" @selected( $sort === 'date')>Date</option>
                        </select>
                    </form>
                </article>
            </aside>

            <aside class="p-5">
                <table class="border-collapse border border-gray-400 rounded-lg w-full">
                    <thead>
                        <tr>
                            <th class="text-sm font-bold">Program Name</th>
                            <th class="text-sm font-bold">Location</th>
                            <th class="text-sm font-bold">Date</th>
                            <th class="text-sm font-bold">Duration</th>
                            <th class="text-sm font-bold">Status</th>
                        </tr>
                    </thead>
                      
                    <tbody>
                        @if ($listOfEvents->isEmpty())
                            <h1 class="bg-red-400 w-full p-3 rounded-lg text-sm font-medium tracking-wide mb-3">No event found</h1>
                        @else
                            @foreach ($listOfEvents as $event)
                                <?php
                                    $eventDateTime = \Carbon\Carbon::parse($event->date . ' ' . $event->time);
                                    $endDateTime = $eventDateTime->copy()->addHours($event->duration);
                                ?>
                                <tr>
                                    <td class="text-xs text-center">
                                        <a href="/super-admin/dashboard/events-programs/{{ $event->id }}/program" class="hover:underline">{{ $event->program_name }}</a>
                                    </td>
                                    <td class="text-xs text-center">{{ $event->location }}</td>
                                    <td class="text-xs text-center">{{ \Carbon\Carbon::parse($eventDateTime)->format('m/d/Y') }}</td>
                                    <td class="text-xs text-center"> {{ $event->duration }} Hours </td>
                                    <td class="text-xs text-center">
                                        @if ($event->cancelled)
                                            <p class="text-red-600 font-bold">Cancelled</p>
                                        @else
                                            @if ($eventDateTime > now())
                                                <p class="text-yellow-600 font-bold">Upcoming</p>
                                            @elseif ($eventDateTime <= now() && now() <= $endDateTime)
                                                <p class="text-blue-600 font-bold">Ongoing</p>
                                            @elseif ($endDateTime < now())
                                                <p class="text-green-600 font-bold">Done</p>
                                            @endif
                                        @endif
                                    </td>
                                </tr> 
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <article class="flex items-center justify-center gap-3 py-3">
                    {{ $listOfEvents->links()}}
                </article>
            </aside>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($events),
            });

            calendar.render();
        });

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

</x-dashboard-layout>
