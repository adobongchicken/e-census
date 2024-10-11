<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title>Edit Account</title>
</head>
<body class="flex items-center justify-center py-10">
    <form action="/super-admin/dashboard/accounts/{{ $user->id }}/update" method="POST" class="w-1/2 flex flex-col gap-4">
        @csrf
        @method('PATCH')
        <header class="flex items-center justify-start bg-red-600 px-5 rounded-lg py-2 gap-3">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard/accounts"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-5"></a>
            </article>
            <img src="{{ asset('assets/logo.png')}}" alt="Logo Image" class="w-16">
            <h1 class="text-white font-bold text-xl text-center w-full">Edit User Account</h1>
        </header>

        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="flex flex-col items-start px-10 gap-5">
            <h1 class="font-bold text-lg">Account Type</h1>
            <article class="flex items-center justify-between w-full">
                <select name="account_type" class="bg-red-600 text-white text-sm p-2 rounded-md cursor-pointer">
                    <option value="Baranggay Admin" @selected( $user->account_type === 'Brgy Admin' )>Barangay Admin</option>
                    <option value="Field Worker" @selected( $user->account_type === 'Field Worker' )>Fieldworker</option>
                </select>
            </article>
        </section>

        <section class="flex flex-col items-start px-10 gap-5">
            <h1 class="font-bold text-lg">Personal Information</h1>
            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Full Name *</label>
                <x-input-box type="text" name="full_name" value="{{ old('full_name', $user->full_name )}}"/>
            </article>

            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Email Address *</label>
                <x-input-box type="email" name="email" value="{{ old('email', $user->email )}}"/>
            </article>

            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Contact Number *</label>
                <x-input-box type="text" name="contact_no" value="{{ old('contact_no', $user->contact_no )}}"/>
            </article>

            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Contact Address *</label>
                <x-input-box type="text" name="contact_address" value="{{ old('contact_address', $user->contact_address )}}"/>
            </article>
        </section>

        @if ($user->account_type !== 'Super Admin')
        <section class="flex flex-col items-start px-10 gap-5">
            <h1 class="font-bold text-lg">Login Credentials</h1>
            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Username *</label>
                <x-input-box type="text" name="username" value="{{ old('username', $user->username )}}" />
            </article>

            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Password *</label>
                <x-input-box type="password" name="password"/>
            </article>

            <article class="flex items-center justify-between w-full ">
                <label class="w-1/2 text-sm font-medium pl-10">Confirm Password *</label>
                <x-input-box type="password" name="confirm_password"/>
            </article>
        </section>
        @endif

        <section class="flex flex-col items-start px-10 gap-5">
            <h1 class="font-bold text-lg">Barangay Assigned</h1>
            <article class="flex items-center justify-between w-full">
                <select name="baranggay_assigned" class="bg-red-600 text-white text-sm p-2 rounded-md cursor-pointer">
                    <option value="" selected>-- Assign Barangay --</option>
                    @foreach ($baranggay as $brgy)
                        <option value="{{ $brgy->baranggay_name }}" @selected( $user->baranggay->baranggay_name === $brgy->baranggay_name )>
                            {{ $brgy->baranggay_name }}
                        </option>
                    @endforeach
                </select>
            </article>
        </section>

        <button class="primary-button">Update</button>
    </form>
</body>
</html>