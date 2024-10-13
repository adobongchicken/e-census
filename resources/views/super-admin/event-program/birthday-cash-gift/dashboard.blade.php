<x-dashboard-layout>
    <x-slot:title>Birthday Cash Gift</x-slot:title>
   <header class="w-full fixed top-0 left-0 z-10">
        <article class="w-full bg-blue-700 flex items-center justify-between px-2 pr-10 p-3">
            <div class="flex items-center justify-center flex-1">
                <h1 class="text-white text-xl">Birthday Cash Gifts</h1>
            </div>
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
        @if (session('message'))
            <h1 class="text-sm font-medium w-full px-5 bg-green-500 py-3 text-white rounded-lg my-2">{{ session('message') }}</h1>
        @endif
        <section class="p-8 bg-white shadow-lg border-gray-200 border-2  rounded-lg">
            <aside class="flex gap-5 h-full">
                <article class="border-2 border-red-700 rounded-md h-full w-[70%] flex p-5">
                    {!! $birthdayChart->container() !!}
                </article>
                <article class="border-2 border-red-700 rounded-md h-full flex-1 flex p-5">
                    {!! $statusChart->container() !!}
                </article>
            </aside>
        </section>
        <section class="w-full">
            <div class="bg-red-600 p-3">
                <h1 class="text-white font-bold text-xl">List of Baranggay</h1>
            </div>
            <div class="flex items-center justify-between bg-blue-800 p-3">
                <form action="#" method="GET" class="relative p-2 w-fit">
                    <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                    <input type="text" class="search-box w-80 text-black font-medium" placeholder="Search barangay..." name="search_person">
                </form>

                <form action="#" method="GET">
                    <select name="sort_by" class="normal-button cursor-pointer" onchange="this.form.submit()">
                        <option selected disabled>-- Sort By --</option>
                        <option>All</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </form>
            </div>    

            <aside class="p-5 w-full">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>Barangay</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangay as $brgy)
                            <tr>
                                <td class="text-center">{{ $brgy->baranggay_name }}</td>
                                <td class="text-center flex items-center justify-center border-none"><a href="{{ route('cashGifts.barangay.super-admin', $brgy->id ) }}"><img src="{{ asset('assets/eye.png')}}" alt="View Image" class="w-5"></a></td>
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