<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body class="h-full flex items-center justify-center">
    <form action="/fieldworker/auth/login" method="POST"
        class="border-2 border-red-500 flex items-start gap-x-3 p-4 rounded-md">
        @csrf
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-16">
        <section class="flex flex-col gap-3">
            <h1 class="text-2xl">Login Field Worker Accounts</h1>
            <article class="flex items-center justify-center flex-col">
                <label for="email" class="text-sm font-bold">Email</label>
                <input type="text" class="w-full border-blue-800 border-2 rounded-md p-2 text-xs outline-none" name="email">
            </article>
            <article class="flex items-center justify-center flex-col">
                <label for="password" class="text-sm font-bold">Password</label>
                <input type="password" class="w-full border-blue-800 border-2 rounded-md p-2 text-xs outline-none" name="password">
            </article>
            <button class="primary-button">Login</button>
            <a href="/" class="primary-button bg-red-700 text-center">Back</a>

            @if ($errors->any())
                <div class="bg-red-300 p-3 rounded-md text-xs font-medium">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    </form>
</body>

</html>
