<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Baranggay Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
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
            text-align: left;
            font-weight: 700;
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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $logo }}" alt="Logo Image" width="70px" class="logo">
        <article>
            <h3>Republica ng Pilipinas</h3>
            <h3>Lungsod Taguig</h3>
            <h3>Tanggap ng Kaugnayan Sa Mga May Kapansanan</h3>
            <h3>Telepono Bilang: 642-3590</h3>
            <h3>pdao.taguig@yahoo.com</h3>
        </article>
        <img src="{{ $pwd_logo }}" alt="Logo Image" width="70px" class="pwd-logo">
    </header>
    <h2>{{ $baranggay }} Person with Disability Lists</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Person with Disability</th>
                <th>Status</th>
                <th>Types of Disability</th>
                <th>Assisted By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($persons as $person)
                @php
                    $allDisabilities = array_merge(
                        $visualImpairment = explode(', ', $person->disabilityType->visual_impairment),
                        $learningDisabilities = explode(', ', $person->disabilityType->learning_disabilities),
                        $hearingImpairment = explode(', ', $person->disabilityType->hearing_impairment),
                        $speechLanguageImpairment = explode(', ', $person->disabilityType->speech_language_impairment),
                        $intellectualDisabilities = explode(', ', $person->disabilityType->intellectual_disabilities),
                        $mobilityImpairment = explode(', ', $person->disabilityType->mobility_impairment),
                        $psychoSocialDisabilities = explode(', ', $person->disabilityType->psycho_social_disabilities),
                        $multipleDisabilities = explode(', ', $person->disabilityType->multiple_disabilities),
                        $otherDisabilities = explode(', ', $person->disabilityType->other_disabilities),
                    );
                    $allDisabilities = array_filter($allDisabilities);
                @endphp
                <tr>
                    <td class="text-center"> {{ $person->id }} </td>
                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                    <td>{{ $person->submittedForm->status }}</td>
                    <td>
                        @foreach ($allDisabilities as $disability)
                            {{ $disability }}
                        @endforeach
                    </td>
                    <td>{{ $person->submittedForm->assisted_by }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        This report provides a detailed listing of {{ count($persons) }} persons with disabilities from
        {{ auth()->user()->baranggay->baranggay_name }}.
    </p>
</body>

</html>
