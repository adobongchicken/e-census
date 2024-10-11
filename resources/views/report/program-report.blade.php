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

    <h2> {{ $event->program_name }}'s Report</h2>
    <table>
        <tbody>
            <tr>
                <td class="title">Total attendees</td>
                <td>{{ $attendees->count() }}</td>
            </tr>
            <tr>
                <td class="title">Total Male</td>
                <td>{{ $male }}</td>
            </tr>
            <tr>
                <td class="title">Total Female</td>
                <td>{{ $female }}</td>
            </tr>
            @foreach ($disabilities as $disability => $count)
                <tr>
                    <td class="title">Disability: {{ $disability }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach

            @foreach ($baranggayAttended as $baranggay => $count)
                <tr>
                    <td class="title">Barangay: {{ $baranggay }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <article>
        <p>
            The report for {{ $event->program_name }} summarizes attendance and participant details. There were
            {{ $attendees->count() }} attendees, including {{ $male }} males and {{ $female }} females.
            Additionally, attendees came from different barangays, with
            @foreach ($baranggayAttended as $baranggay => $count)
                {{ $baranggay }} having {{ $count }},
            @endforeach
            participants.
    </article>
</body>

</html>
