<x-fieldworker-dashboard-layout>
    <x-slot:title>Birthday Cash Gift - {{ auth()->user()->baranggay->baranggay_name }}</x-slot:title>
    <header class="w-full relative">
        <article class="w-full bg-blue-800 flex items-center justify-between px-2 pr-10 p-3">
            <h1 class="text-white text-xl flex-1 text-center">{{ auth()->user()->baranggay->baranggay_name }}</h1>
            <div class="flex items-center gap-2">
                <button class="normal-button">Download Reports</button>
                <article class="bg-white p-2 rounded-lg ">
                    <div id="notification-button"><img src="{{ asset('assets/notification.png') }}" alt="Notification Image" class="w-5 cursor-pointer "></div>
                </article>
            </div>
        </article>
    </header>
    <article class="flex items-center justify-center absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] w-[100%] z-10 hidden" id="notification-modal">
        <main class="w-1/2 bg-[#e4ccff]">
            <header class="bg-blue-800 p-5 rounded-md">
                <h1 class="text-white text-lg text-center">Notifications</h1>
            </header>
            <section class="p-3 flex flex-col gap-5">
                @if ($birthdayNotification->count() > 0)
                    @foreach ($birthdayNotification as $birthday)
                        <article class="flex flex-col gap-1 {{ $birthday->count() > 1 ? 'border-b border-red-700 pb-3' : ''}} ">
                            <div class="flex items-center justify-between">
                                <h1 class="font-bold text-sm">Name: <span class="text-xs font-medium">{{ $birthday->first_name }} {{ $birthday->last_name }}</span></h1>
                                <p class="text-xs font-medium">{{ \Carbon\Carbon::parse($birthday->date_of_birth)->format('F j, Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                @else
                    <h1 class="text-lg font-semibold tracking-wide">No Upcoming Birthday</h1>
                @endif
                <button class="primary-button bg-red-700" id="close-notification">Close</button>
            </section>
        </main>
    </article>
    <main class="p-5">
        <section class="w-full">
            <div class="bg-blue-800 p-3 flex justify-between">
                <h1 class="text-white font-bold text-xl">List of Birthday Celebrants</h1>
                <button class="normal-button">Download List</button>
            </div>
            <div class="flex items-center justify-between bg-blue-400 p-3">
                <form action="#" method="GET" class="relative p-2 w-fit">
                    <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                    <input type="text" class="search-box w-80 text-black font-medium" placeholder="Search person..." name="search_person">
                </form>

                <form action="#" method="GET">
                    <select name="sort_by" class="normal-button cursor-pointer" onchange="this.form.submit()">
                        <option selected disabled>-- Sort By --</option>
                        <option>All</option>
                        <option value="processing">Processing</option>
                        <option value="unreleased">Unreleased</option>
                        <option value="released">Released</option>
                    </select>
                </form>
            </div>
            @if (session('message'))
                <h1 class="text-sm font-medium w-full px-5 bg-green-500 py-3 text-white rounded-lg my-2">{{ session('message') }}</h1>
            @endif
            <aside class="p-5 w-full">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Assisted</th>
                            <th>Status</th>
                            <th>Image Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($persons as $person)
                            <tr>
                                <td class="text-center text-sm">{{ $person->id }}</td>
                                <td class="text-center text-sm"><a href="/fieldworker/events-programs/birthday-cash-gifts/baranggay/status/{{$person->id}}" class="hover:underline">{{ $person->first_name }} {{ $person->last_name }}</a></td>
                                <td class="text-center text-sm">{{ $person->date_of_birth }}</td>
                                <td class="text-center text-sm">{{ $person->present_house }} {{ $person->present_sitio }}, {{ $person->present_city }}</td>
                                <td class="text-center text-sm">{{ $person->submittedForm->assisted_by }}</td>
                                <td class="text-center text-sm capitalize">{{ $person->birthdayCashGift->status }}</td>
                                <td class="text-center text-sm capitalize"> 
                                    @if ($person->birthdayCashGift->proof)
                                        <img src="{{asset('proof/'. $person->birthdayCashGift->proof)}}" alt="" class="w-32">
                                    @else
                                        <p>No Proof</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </aside>    
        </section>
    </main>
    <script src="{{ $birthdayChart->cdn() }}"></script>
    <script src="{{ $statusChart->cdn() }}"></script>
    {{ $birthdayChart->script() }}
    {{ $statusChart->script() }}
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