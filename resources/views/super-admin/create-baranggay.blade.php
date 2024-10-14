<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title>Create New Barangay</title>
</head>

<body class="h-full flex items-center justify-center">
    <form action="/super-admin/dashboard/create-baranggay/create" method="POST" class="w-full max-w-lg flex flex-col gap-9 bg-white shadow-md p-6 rounded-md">
        @csrf
        <header class="flex items-center bg-blue-800 p-3 rounded-md gap-x-4">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard"><img src="{{ asset('assets/left.png')}}" alt="Back Image" class="w-5"></a>
            </article>

            <img src="{{ asset('assets/logo.png')}}" alt="Logo" class="w-10">
            <h1 class="text-white">Add New Barangay</h1>
        </header>

        <article class="flex items-center">
            <label for="baranggay_name" class="w-1/2 text-sm">Barangay Name*</label>
            <x-input-box type="text" name="baranggay_name" id="baranggay_name" value="{{ old('baranggay_name') }}" required />
        </article>

        <article class="flex items-center">
            <label for="baranggay_capt_name" class="w-1/2 text-sm">Barangay Captain*</label>
            <x-input-box type="text" name="baranggay_capt_name" id="baranggay_capt_name" value="{{ old('baranggay_capt_name') }}" required />
        </article>

        <article class="flex items-center">
            <label for="baranggay_location" class="w-1/2 text-sm">Barangay Location*</label>
            <x-input-box type="text" name="baranggay_location" id="baranggay_location" value="{{ old('baranggay_location') }}" required />
        </article>

        <article class="flex items-center">
            <label for="baranggay_contact" class="w-1/2 text-sm">Barangay Contact (Optional)</label>
            <x-input-box type="text" name="baranggay_contact" id="baranggay_contact" value="{{ old('baranggay_contact') }}" />
        </article>

        <article class="flex items-center">
            <label for="baranggay_desc" class="w-1/2 text-sm">Barangay Description (Optional)</label>
            <x-input-box type="text" name="baranggay_desc" id="baranggay_desc" value="{{ old('baranggay_desc') }}" />
        </article>

        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
<<<<<<< Updated upstream

        <button type="submit" class="primary-button">Add</button>
=======
        <button class="primary-button bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition">Add</button>
        </form>
>>>>>>> Stashed changes
    </form>
</body>

</html>
