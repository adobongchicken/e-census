<x-dashboard-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <header class="w-full relative">
        <article class="w-full bg-red-600 flex items-center justify-between px-2 pr-10 p-3">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-12">
                <h1 class="text-white text-xl">Barangays</h1>
            </div>

            <article class="bg-white p-2 rounded-lg ">
                <div id="notification-button"><img src="{{ asset('assets/notification.png') }}" alt="Notification Image" class="w-5 cursor-pointer "></div>
            </article>
        </article>

        <article class="w-full flex items-center justify-between bg-blue-800 text-white p-2">
            <h1 class="flex-1 text-center font-bold">Reports</h1>
            <a href="{{ route('generate-baranggay-report') }}" class="normal-button">Download Reports</a>
        </article>
    </header>

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

    <article class="px-3">
        @if (session('message'))
            <h1 class="text-sm font-medium w-full px-5 bg-green-500 py-3 text-white rounded-lg my-2">{{ session('message') }}</h1>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </article>

    <section class="p-3 w-full flex gap-5 flex-col lg:flex-col xl:flex-row">
        <aside class="flex flex-col gap-4 flex-1 lg:w-full xl:w-1/2">
            <article class="flex items-center gap-5 flex-1">
                <div class="border-red-700 border-2 h-[250px] w-full flex justify-center rounded-lg pt-5">
                    {!! $totalGenderChart->container() !!}
                </div>
                <div class="border-red-700 border-2 h-[250px] w-full flex justify-center rounded-lg pt-5">
                    {!! $ageChart->container() !!}
                </div>
            </article>

            <article class="flex items-center gap-5 flex-1">
                <div class="border-red-700 border-2 h-[250px] w-full flex justify-center rounded-lg pt-5">
                    {!! $civilStatusChart->container() !!}
                </div>
                <div class="border-red-700 border-2 h-[250px] w-full flex justify-center rounded-lg pt-5">
                    {!! $statusChart->container() !!}
                </div>
            </article>
        </aside>

        <article class="border-red-700 border-2 w-full flex justify-center h-[515px] rounded-lg pt-5 flex-1">
            {!! $pwdTypeChart->container() !!}
        </article>
    </section>

    <section>
        <article class="bg-red-600 flex items-center justify-between p-2">
            <h1 class="text-white font-medium text-sm text-end w-[15%]">List of Barangays</h1>
            <a href="/super-admin/dashboard/create-baranggay" class="normal-button">Add Barangay <span class="font-bold">+</span></a>
        </article>
        <article class="bg-blue-800 flex items-center justify-end px-3">
            <form action="{{ route('dashboard') }}" method="GET" class="relative p-2 w-fit mr-64">
                <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                <input type="text" class="search-box w-80" placeholder="Search baranggays..." name="search_baranggay">
            </form>

            <form action="{{ route('dashboard') }}" method="GET">
                <select name="sort" class="normal-button" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By --</option>
                    <option value="Ascending" @selected($sort === 'Ascending')>Ascending</option>
                    <option value="Descending" @selected($sort === 'Descending')>Descending</option>
                </select>
            </form>
        </article>
    </section>

    <section class="p-10">
        <table class="border-collapse border border-gray-400 rounded-lg w-full">
            <thead>
                <tr>
                    <th class="text-sm font-bold">Barangay</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($baranggays as $brgy)
                <tr>
                    <td>{{ $brgy->baranggay_name }}</td>
                    <td>
                        <div class="flex items-center justify-center gap-x-3">
                            <a href="/super-admin/dashboard/baranggay/{{ $brgy->id }}/report"><img src="{{ asset('assets/eye.png')}}" alt="View Image" class="w-5"></a>
                            <a href="/super-admin/dashboard/baranggay/{{ $brgy->id }}/edit"><img src="{{ asset('assets/pencil.png')}}" alt="Edit Image" class="w-5"></a>
                            <form action="/super-admin/dashboard/baranggay/{{ $brgy->id }}/delete" method="POST" onsubmit="return confirmDelete()">
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
            {{ $baranggays->links()}}
        </article>
    </section>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this baranggay? This action cannot be undone.');
        }
    </script>
    <script src="{{ $totalGenderChart->cdn() }}"></script>
    <script src="{{ $civilStatusChart->cdn() }}"></script>
    <script src="{{ $ageChart->cdn() }}"></script>
    <script src="{{ $statusChart->cdn() }}"></script>
    <script src="{{ $pwdTypeChart->cdn() }}"></script>
    {{ $totalGenderChart->script() }}
    {{ $civilStatusChart->script() }}
    {{ $ageChart->script() }}
    {{ $statusChart->script() }}
    {{ $pwdTypeChart->script() }}
    <script>
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
