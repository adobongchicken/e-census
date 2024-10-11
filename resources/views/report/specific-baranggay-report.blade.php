<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>{{ $baranggay }} Report</title>
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
        <caption>Total Gender</caption>
        <thead>
            <tr>
                <th>Male</th>
                <th>Female</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $male }}</td>
                <td>{{ $female }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <caption>Age Groups</caption>
        <thead>
            <tr>
                <th>0 - 18 years old</th>
                <th>19 - 65 years old</th>
                <th>65+ years old</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sophomore }}</td>
                <td>{{ $junior }}</td>
                <td>{{ $senior }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <caption>Civil Status Categories</caption>
        <thead>
            <tr>
                <th>Single</th>
                <th>Married</th>
                <th>Widowed</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $single }}</td>
                <td>{{ $married }}</td>
                <td>{{ $widowed }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <caption>PWD Status</caption>
        <thead>
            <tr>
                <th>Active</th>
                <th>Moved</th>
                <th>Deceased</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $active }}</td>
                <td>{{ $moved }}</td>
                <td>{{ $deceased }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <caption>Disability Type</caption>
        <tbody>
            @foreach ($disabilities as $disability => $count)
                <tr>
                    <td class="title">{{ $disability }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        This report for {{ $baranggay }} provides a detailed overview of various demographics. There are
        {{ $male }} males and {{ $female }} females in the community. The age gap shows
        {{ $sophomore }} individuals aged 0-18, {{ $junior }} aged 19-65, and {{ $senior }} aged 65
        and older. Regarding civil status, there are {{ $single }} Single, {{ $married }} Married
        individuals, and {{ $widowed }} Widowed persons. The report details the status of people with disabilities
        (PWD), including 5 active, 10 who have moved, and 5 who are deceased.
        <br />
        <br />
        The disability types are categorized as follows:
        <br />
        @foreach ($disabilities as $disability => $count)
            - {{ $disability }}: {{ $count }} <br />
        @endforeach
    </p>
</body>

</html>
