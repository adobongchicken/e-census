<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Program</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
        border: 1px solid black;
    }

    thead {
        background-color: #f0f0f0;
    }

    th {
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    caption {
        font-size: 15px;
        text-align: center;
        font-weight: 700;
    }

    .title {
        width: 250px;
        text-align: left;
    }

    .page-break {
        page-break-after: always;
    }

    h1 {
        text-align: center;
    }

    p {
        font-size: 14px;
    }

    li {
        list-style-type: disc;
    }

    span {
        font-size: 11px;
        font-weight: normal;
    }

    header {
        position: relative;
        text-align: center;
        margin-bottom: 30px;
    }

    header .logo {
        position: absolute;
        left: 0;
    }

    header .pwd-logo {
        position: absolute;
        right: 0;
    }

    header article {
        display: inline-block;
        vertical-align: top;
        margin: 0 10px;
        text-align: center;
    }
</style>

<body>
    <header>
        <img src="{{ $logo }}" alt="Logo Image" width="150px" class="logo">
        <article>
            <h3>Republica ng Pilipinas</h3>
            <h3>Lungsod Taguig</h3>
            <h3>Tanggap ng Kaugnayan Sa Mga May Kapansanan</h3>
            <h3>Telepono Bilang: 642-3590</h3>
            <h3>pdao.taguig@yahoo.com</h3>
        </article>
        <img src="{{ $pwd_logo }}" alt="Logo Image" width="150px" class="pwd-logo">
    </header>
    <h1>{{ $event->program_name }}</h1>
    <h3>Date: <span>{{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}</span></h3>
    <h3>Time: <span>{{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span></h3>
    <h3>Program Description: <span>{{ $event->description }}</span></h3>
    <h3>Residency Requirements: <span>{{ $event->residency_requirements }}</span></h3>
    <h3>Types of Disability Groups</h3>
    <ul>
        @php
            $allDisabilities = array_merge(
                $visualImpairment = explode(', ', $event->visual_impairment),
                $learningDisabilities = explode(', ', $event->learning_disabilities),
                $hearingImpairment = explode(', ', $event->hearing_impairment),
                $speechLanguageImpairment = explode(', ', $event->speech_language_impairment),
                $intellectualDisabilities = explode(', ', $event->intellectual_disabilities),
                $mobilityImpairment = explode(', ', $event->mobility_impairment),
                $psychoSocialDisabilities = explode(', ', $event->psycho_social_disabilities),
                $multipleDisabilities = explode(', ', $event->multiple_disabilities),
                $otherDisabilities = explode(', ', $event->other_disabilities),
            );
            $allDisabilities = array_filter($allDisabilities);
        @endphp

        @foreach ($allDisabilities as $disability)
            <li>{{ $disability }}</li>
        @endforeach
    </ul>
    <h3>Organizers</h3>

    <table>
        <thead>
            <tr>
                <th>Organizer Name</th>
                <th>Organizer Contact Number</th>
                <th>Organizer Email</th>
            </tr>
        </thead>
        <tbody>
            @if (!is_null($event->organizer_name) && !is_null($event->contact_number) && !is_null($event->email))
                <tr>
                    <td>{{ $event->organizer_name }}</td>
                    <td>{{ $event->contact_number }}</td>
                    <td>{{ $event->email }}</td>
                </tr>
            @endif
            @if (!is_null($event->organizer_name_2) && !is_null($event->contact_number_2) && !is_null($event->email_2))
                <tr>
                    <td>{{ $event->organizer_name_2 }}</td>
                    <td>{{ $event->contact_number_2 }}</td>
                    <td>{{ $event->email_2 }}</td>
                </tr>
            @endif
            @if (!is_null($event->organizer_name_3) && !is_null($event->contact_number_3) && !is_null($event->email_3))
                <tr>
                    <td>{{ $event->organizer_name_3 }}</td>
                    <td>{{ $event->contact_number_3 }}</td>
                    <td>{{ $event->email_3 }}</td>
                </tr>
            @endif
        </tbody>
    </table>





</body>

</html>
