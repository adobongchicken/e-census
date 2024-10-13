<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            text-align: start;
            font-weight: 700;
            margin-bottom: 10px;
            margin-top: 50px;
        }

        .title {
            width: 250px;
            text-align: left;
        }

        .page-break {
            page-break-after: always;
        }

        h1,
        h2 {
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

        .conclusion {
            margin-top: 40px;
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
        <caption>Status</caption>
        <thead>
            <tr>
                <th>Name</th>
                <th>Birthdate</th>
                <th>Address</th>
                <th>Assisted</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($persons as $person)
                    <tr>
                        <td class="text-center text-sm">{{ $person->first_name }} {{ $person->last_name }}</td>
                        <td class="text-center text-sm">{{ $person->date_of_birth }}</td>
                        <td class="text-center text-sm">{{ $person->present_house }} {{ $person->present_sitio }},
                            {{ $person->present_city }}</td>
                        <td class="text-center text-sm">{{ $person->submittedForm->assisted_by }}</td>
                        <td class="text-center text-sm capitalize">{{ $person->birthdayCashGift->status }}</td>
                    </tr>
                @endforeach
            </tr>
        </tbody>
    </table>

</body>

</html>