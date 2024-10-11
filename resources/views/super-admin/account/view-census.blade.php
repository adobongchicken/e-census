<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('assets/logo.png')}}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title> {{ $baranggay->baranggay_name }} </title>
</head>
<body>
    <header>
        <nav class="bg-blue-700 p-5 flex items-center justify-between">   
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard/accounts"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-5"></a>
            </article>
            <h1 class="text-white text-xl font-medium text-center w-full">View Census Data</h1>
        </nav>
        <nav class="w-full bg-[#0d99ff] flex items-center justify-between px-5 py-2">
            <article>
                <form action="{{ route('view-census', $baranggay->id) }}" class="relative p-2 w-fit">
                    <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                    <input type="text" class="search-box w-80 text-black font-medium" placeholder="Search person..." name="search_person">
                </form>
            </article>

            <form action="{{ route('view-census', $baranggay->id ) }}" method="GET">
                <select name="sort" class="normal-button" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By --</option>
                    <option value="id" @selected($sort === 'id')>ID</option>
                    <option value="name" @selected($sort === 'name')>Name</option>
                    <option value="status" @selected($sort === 'status')>Status</option>
                </select>
            </form>
        </nav>
    </header>

    <section class="p-10">
        <table class="border-collapse border border-gray-400 rounded-lg w-full">
            <thead>
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Person with Disabilities</th>
                    <th class="text-sm font-bold">Status</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($persons as $person)
                    <tr>
                        <td class="text-center">{{ $person->id }}</td>
                        <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                        <td>{{ $person->submittedForm->status }}</td>
                        <td>
                            <div class="flex items-center justify-center gap-x-3">
                                <a href="/super-admin/dashboard/baranggay/pwd/{{ $person->id }}/view"><img src="{{ asset('assets/eye.png')}}" alt="View Image" class="w-5"></a>
                                <a href="/super-admin/dashboard/baranggay/pwd/{{ $person->id }}/edit"><img src="{{ asset('assets/pencil.png')}}" alt="Edit Image" class="w-5"></a>
                                <form action="/super-admin/dashboard/baranggay/pwd/{{ $person->id }}/delete" method="POST" onsubmit="return confirmDelete()">
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
    </script>
</body>
</html>