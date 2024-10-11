<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>

<body>
    <h3>Dear Participants,</h3>
    <p>We regret to inform you that the <strong>{{ $eventDetails->program_name }}</strong> scheduled for <strong>{{ Carbon\Carbon::parse($eventDetails['date'])->format('F j, Y') }}</strong> has been cancelled.</p>
    <p class="message"> 
        <strong style="font-size: 15px">Reason of Cancellation:</strong><br/>
        {!! nl2br(e($cancellationMesssage)) !!}
    </p>
    <p>
        We apologize for any inconvenience this may cause. Thank you for your understanding.
    </p>
</body>

</html>
