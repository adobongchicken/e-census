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
    <title>Change Password</title>
</head>

<body class="h-full flex items-center justify-center">

    <!-- Form Structure -->
    <form action="/administrator/change-password/{{ $user->id }}" method="POST" class="w-1/2 flex flex-col gap-9 bg-white shadow-md">
        @csrf
        @method('PATCH')

        <!-- Error Handling -->
        @if ($errors->any())
        <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Header -->
        <header class="flex items-center bg-red-600 p-3 rounded-md gap-x-4">
        <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-5"></a>
            </article>

            <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
            <h1 class="text-white font-bold text-xl text-center w-full">Change Password</h1>
        </header>

        <!-- Form Content -->
        <section class="flex flex-col items-start px-10 gap-5">
            <h1 class="font-bold text-lg">Login Credentials</h1>
            
            <!-- Username Field -->
            <article class="flex items-center justify-between w-full">
                <label class="w-1/2 text-sm font-medium pl-10">Username *</label>
                <x-input-box type="text" name="username" value="{{ old('username', $user->username) }}" />
            </article>

            <!-- Password Field -->
            <article class="flex items-center justify-between w-full">
                <label class="w-1/2 text-sm font-medium pl-10">Password *</label>
                <x-input-box type="password" name="password" />
            </article>

            <!-- Confirm Password Field -->
            <article class="flex items-center justify-between w-full">
                <label class="w-1/2 text-sm font-medium pl-10">Confirm Password *</label>
                <x-input-box type="password" name="confirm_password" />
            </article>
        </section>

        <!-- Submit and Back Buttons -->
        <section class="flex flex-col items-center gap-5">
            <button class="primary-button bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition w-64 mb-10">
                Change Password
            </button>
        </section>
    </form>

</body>

</html>
