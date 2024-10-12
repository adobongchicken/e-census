<x-dashboard-layout>
    <x-slot:title>User Dashboard</x-slot:title>
    <header class="w-full fixed top-0 left-0 z-10">
    <article class="w-full bg-red-600 flex items-center justify-between px-2 pr-10 p-3">
    <div class="flex items-center justify-center flex-1">
                <h1 class="text-white text-xl">Accounts</h1>
            </div>

            <article class="bg-white p-2 rounded-lg overflow-hidden">
                <div id="notification-button"><img src="{{ asset('assets/notification.png') }}" alt="Notification Image" class="w-5 cursor-pointer "></div>
            </article>
        </article>

        <article class="w-full flex items-center justify-between bg-[#0d99ff] text-white p-2">
            <a href="/super-admin/dashboard/accounts/create-account" class="normal-button py-1 font-medium flex items-center gap-2 justify-center">
                Create Account 
                <span class="text-lg font-bold">+</span>
            </a>

            <article >
                <form action="{{ route('account-dashboard') }}" method="GET" class="relative p-2 w-fit">
                    <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                    <input type="text" class="search-box w-80 text-black font-medium" placeholder="Search person..." name="search_person">
                </form>
            </article>

            <form action="{{ route('account-dashboard') }}" method="GET">
                <select name="sort_by" class="normal-button cursor-pointer" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By --</option>
                    <option>All</option>
                    <option value="Super Admin" @selected($sort === 'Super Admin')>Super Admin</option>
                    <option value="Baranggay Admin" @selected($sort === 'Baranggay Admin')>Barangay Admin</option>
                    <option value="Field Worker" @selected($sort === 'Field Worker')>Field Worker</option>
                </select>
            </form>
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
    
    <section class="px-10 py-5 flex flex-col gap-3 pt-30" >
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
            <h1 class="text-sm font-medium w-full px-5 bg-green-500 py-3 text-white rounded-lg my-2">{{ session('message') }}</h1>
        @endif
        
        <table class="border-collapse border border-gray-400 rounded-lg w-full">
            <thead>
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Account Name</th>
                    <th class="text-sm font-bold">Roles</th>
                    <th class="text-sm font-bold">Assigned Brgy</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($accounts->isEmpty())
                    <h1 class="bg-red-400 w-full p-3 rounded-lg text-sm font-medium tracking-wide">No record found</h1>
                @else
                    @foreach ($accounts as $account)
                        <tr>
                            <td class="text-center"> {{ $account->id }} </td>
                            <td>{{ $account->full_name }}</td>
                            <td>{{ $account->account_type}}</td>
                            <td>{{ $account->baranggay->baranggay_name}}</td>
                            <td>
                                <div class="flex items-center justify-center gap-x-3">
                                    <a href="/super-admin/dashboard/accounts/{{ $account->baranggay_id }}/view-census-data"><img src="{{ asset('assets/eye.png')}}" alt="View Image" class="w-5"></a>
                                    <a href="/super-admin/dashboard/accounts/{{ $account->id }}/edit"><img src="{{ asset('assets/pencil.png')}}" alt="Edit Image" class="w-5"></a>
                                    <form action="/super-admin/dashboard/accounts/{{ $account->id }}/delete" method="POST" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="flex items-center justify-center"><img src="{{ asset('assets/trash.png')}}" alt="Delete Image" class="w-5"></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach    
                @endif
            </tbody>
        </table>
        <article class="flex items-center justify-center gap-3 py-5">
            {{ $accounts->links('vendor.pagination.tailwind')}}
        </article>
    </section>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this account? This action cannot be undone.');
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
</x-dashboard-layout>