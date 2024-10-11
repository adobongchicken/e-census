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

<body class="flex items-center justify-center h-full">
    <form action="/administrator/change-password/{{ $user->id }}" class="flex flex-col items-start px-10 gap-5 border-red-700 border-2 py-10 rounded-lg w-1/2" method="POST">
        @csrf
        @method('PATCH')
        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md w-full">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="font-bold text-lg">Change Password</h1>
        <article class="flex items-center justify-between w-full ">
            <label class="w-1/2 text-sm font-medium">Username *</label>
            <x-input-box type="text" name="username" value="{{ old('username', $user->username) }}" />
        </article>

        <article class="flex items-center justify-between w-full ">
            <label class="w-1/2 text-sm font-medium">Password *</label>
            <x-input-box type="password" name="password" />
        </article>

        <article class="flex items-center justify-between w-full ">
            <label class="w-1/2 text-sm font-medium">Confirm Password *</label>
            <x-input-box type="password" name="confirm_password" />
        </article>
        <button class="primary-button self-center w-64">Change password</button>
        <a href="{{ route('dashboard') }}" class="primary-button self-center w-64 text-center bg-red-700">Back</>
    </form>

</body>

</html>
