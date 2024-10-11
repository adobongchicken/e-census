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
    <title>Edit Barangay</title>
</head>

<body class="h-full flex items-center justify-center">
    <form action="/super-admin/dashboard/baranggay/{{ $baranggay->id }}/update" method="POST" class="w-1/2 flex flex-col gap-9 bg-white shadow-md">
        @csrf
        @method('PATCH')
        <header class="flex items-center bg-blue-800 p-3 rounded-md gap-x-4">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-5"></a>
            </article>
            <img src="{{ asset('assets/logo.png')}}" alt="Logo" class="w-10">
            <h1 class="text-white">Update Barangay</h1>
        </header>
        
        <article class="flex items-center px-10">
            <label for="baranggayName" class="w-1/2 text-sm">Barangay Name*</label>
            <x-input-box type="text" name="baranggay_name" value="{{ old('baranggay_name', $baranggay->baranggay_name) }}"/>
        </article>

        <article class="flex items-center px-10">
            <label for="baranggayName" class="w-1/2 text-sm">Barangay Captain*</label>
            <x-input-box type="text" name="baranggay_capt_name" value="{{ old('baranggay_capt_name', $baranggay->baranggay_capt_name) }}"/>
        </article>

        <article class="flex items-center px-10">
            <label for="baranggayName" class="w-1/2 text-sm">Barangay Location*</label>
            <x-input-box type="text" name="baranggay_location" value="{{ old('baranggay_location', $baranggay->baranggay_location) }}"/>
        </article>

        <article class="flex items-center px-10">
            <label for="baranggayName" class="w-1/2 text-sm">Barangay Contact (Optional) </label>
            <x-input-box type="text" name="baranggay_contact" value="{{ old('baranggay_contact', $baranggay->baranggay_contact) }}"/>
        </article>

        <article class="flex items-center px-10">
            <label for="baranggayName" class="w-1/2 text-sm">Barangay Description (Optional) </label>
            <x-input-box type="text" name="baranggay_desc" value="{{ old('baranggay_desc', $baranggay->baranggay_desc) }}"/>
        </article>
        <button class="primary-button">Update</button>
    </form>
</body>

</html>
