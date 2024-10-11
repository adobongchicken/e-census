<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body>
    @php
        $personInvited = session('invitationData');
        use Carbon\Carbon;
    @endphp
    <h3>You are invited to {{ $personInvited['program_name'] }}!</h3>

    <p>
        Dear Customers,<br><br>
        We are excited to invite you to our upcoming program specifically designed for persons with disabilities (PWD)
        that focuses on their unique needs.
        {!! $personInvited['description'] !!}<br><br>
        Please prepare all of the residency requirements mentioned below:<br><br />
        <i><strong>{!! nl2br(e($personInvited['residency_requirements'])) !!}</strong></i><br><br>
        We look forward to your participation!<br>
    </p>

    <p>
        <span>Location: {!! nl2br(e($personInvited['location'])) !!}</span><br/>
        <span>Venue: {!! nl2br(e($personInvited['venue'])) !!}</span>
    </p>
    <p>
        Date: {{ Carbon::parse($personInvited['date'])->format('F j, Y') }}<br>
        Time: {{ nl2br(e(Carbon::parse($personInvited['time'])->format('h:i A'))) }}
    </p>
</body>

</html>
