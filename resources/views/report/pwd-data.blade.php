<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Person with Disability Data</title>
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
</head>

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
    <table>
        <caption>Personal Information</caption>
        <tbody>
            <tr>
                <td class="title">First Name</td>
                <td>{{ $person->first_name }}</td>
            </tr>
            <tr>
                <td class="title">Middle Name</td>
                <td>{{ $person->middle_name }}</td>
            </tr>
            <tr>
                <td class="title">Last Name</td>
                <td>{{ $person->last_name }}</td>
            </tr>
            <tr>
                <td class="title">Present House</td>
                <td>{{ $person->present_house }}</td>
            </tr>
            <tr>
                <td class="title">Present Sitio</td>
                <td>{{ $person->present_sitio }}</td>
            </tr>
            <tr>
                <td class="title">Present Baranggay</td>
                <td>{{ $person->present_baranggay }}</td>
            </tr>
            <tr>
                <td class="title">Present City</td>
                <td>{{ $person->present_city }}</td>
            </tr>
            <tr>
                <td class="title">Present Province</td>
                <td>{{ $person->present_province }}</td>
            </tr>
            <tr>
                <td class="title">Province House</td>
                <td>{{ $person->province_house }}</td>
            </tr>
            <tr>
                <td class="title">Province Sitio</td>
                <td>{{ $person->province_sitio }}</td>
            </tr>
            <tr>
                <td class="title">Province Barangay</td>
                <td>{{ $person->province_baranggay }}</td>
            </tr>
            <tr>
                <td class="title">Province City</td>
                <td>{{ $person->province_city }}</td>
            </tr>
            <tr>
                <td class="title">Province Province</td>
                <td>{{ $person->province_province }}</td>
            </tr>
            <tr>
                <td class="title">Sex</td>
                <td>{{ $person->sex }}</td>
            </tr>
            <tr>
                <td class="title">Civil Statis</td>
                <td>{{ $person->civil_status }}</td>
            </tr>
            <tr>
                <td class="title">Date of Birth</td>
                <td>{{ \Carbon\Carbon::parse($person->date_of_birth)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td class="title">Contact Number</td>
                <td>{{ $person->contact_no }}</td>
            </tr>
            <tr>
                <td class="title">Email Address</td>
                <td>{{ $person->email }}</td>
            </tr>
            <tr>
                <td class="title">Height</td>
                <td>{{ $person->height }}</td>
            </tr>
            <tr>
                <td class="title">Weight</td>
                <td>{{ $person->weight }}</td>
            </tr>
            <tr>
                <td class="title">Religion</td>
                <td>{{ $person->religion }}</td>
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    <table>
        <caption>Educational Attainment</caption>
        <tbody>
            <tr>
                <td class="title">Elementary School</td>
                <td>{{ $person->educationalAttainment->elementary_school }}</td>
            </tr>
            <tr>
                <td class="title">Elementary School Address</td>
                <td>{{ $person->educationalAttainment->elementary_school_address }}</td>
            </tr>
            <tr>
                <td class="title">High School</td>
                <td>{{ $person->educationalAttainment->high_school }}</td>
            </tr>
            <tr>
                <td class="title">Vocational School</td>
                <td>{{ $person->educationalAttainment->vocational_school }}</td>
            </tr>
            <tr>
                <td class="title">Vocational Address</td>
                <td>{{ $person->educationalAttainment->vocational_address }}</td>
            </tr>
            <tr>
                <td class="title">College School</td>
                <td>{{ $person->educationalAttainment->college_school }}</td>
            </tr>
            <tr>
                <td class="title">College Address</td>
                <td>{{ $person->educationalAttainment->college_address }}</td>
            </tr>
        </tbody>
    </table>
    @if ($person->employmentRecord)
        <div class="page-break"></div>
        <table>
            <caption>Employment Record</caption>
            <tbody>
                @foreach ($person->employmentRecord as $index => $record)
                    <tr>
                        <td class="title">Duration {{ $index + 1 }}</td>
                        <td>{{ $record->duration }} </td>
                    </tr>
                    <tr>
                        <td class="title">Company Name {{ $index + 1 }}</td>
                        <td>{{ $record->company_name }} </td>
                    </tr>
                    <tr>
                        <td class="title">Company Address {{ $index + 1 }}</td>
                        <td>{{ $record->company_address }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($person->disabilityType)
        <div class="page-break"></div>
        <table>
            <caption>Disability Type</caption>
            <tbody>
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
                    @foreach ($allDisabilities as $disability)
                        <td>
                            {{ $disability }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @endif
</body>

</html>
