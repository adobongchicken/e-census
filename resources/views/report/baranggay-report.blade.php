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
            margin-top: 10px;
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
                <td>{{ $totalMale }}</td>
                <td>{{ $totalFemale }}</td>
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
                <td>{{ $totalSophomore }}</td>
                <td>{{ $totalJunior }}</td>
                <td>{{ $totalSenior }}</td>
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
                <td>{{ $totalSingle }}</td>
                <td>{{ $totalMarried }}</td>
                <td>{{ $totalWidowed }}</td>
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
                <td>{{ $totalActive }}</td>
                <td>{{ $totalMoved }}</td>
                <td>{{ $totalDeceased }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <caption>Disability Types</caption>
        <thead>
            <tr>
                @foreach ($disabilities as $disability => $count)
                    <td>{{ $disability }}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($disabilities as $disability => $count)
                    <td>{{ $count }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    <article>
        <p>
            This report provides an overview of persons with disabilities. We have {{ $totalMale }}
            males and {{ $totalFemale }} females The age groups include {{ $totalSophomore }} individuals aged 0 - 18
            years, {{ $totalJunior }} aged 19 - 65
            years, and {{ $totalSenior }} aged 65 and older. In terms of civil status, there are {{ $totalSingle }}
            Single, {{ $totalMarried }} Married, and {{ $totalWidowed }} Widowed individuals. The PWD status shows
            {{ $totalActive }} active individuals, {{ $totalMoved }} who have moved, and {{ $totalDeceased }}
            deceased, guiding our resource allocation. 
            <br />
            <br />
            The disability types are categorized as follows:
            <br />
            @foreach ($disabilities as $disability => $count)
                {{ $disability }}: {{ $count }} <br />
            @endforeach
        </p>
    </article>
</body>

</html>
