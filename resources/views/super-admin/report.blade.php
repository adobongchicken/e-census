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
    <title>Summary Report</title>
    <style>
        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5rem;
            }

            header h1:nth-of-type(2) {
                font-size: 1rem;
            }

            .search-box {
                width: 100%;
            }

            section {
                flex-direction: column;
                align-items: center;
            }

            .chart-container {
                width: 90%;
                margin-bottom: 20px;
            }
        }

        .chart-container {
            width: 24%;
        }

        /* Styles for the normal-button class */
        .normal-button {
            background-color: #0d99ff; /* Example button color */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header class="w-full bg-red-600 flex items-center justify-between p-2">
        <article class="flex items-center gap-3 w-full">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard"><img src="{{ asset('assets/left.png')}}" alt="Back Image" class="w-5"></a>
            </article>
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
            <h1 class="text-white text-xl font-bold text-end flex-grow">{{ $baranggay->baranggay_name }}</h1>
        </article>

        <h1 class="text-white text-lg font-bold px-10 py-6 border-2 border-red-800 rounded-md">{{ now()->format('M - d - Y') }}</h1>
    </header>

    <section class="flex items-center justify-around py-5 h-auto">
        <article class="border-red-500 border-2 rounded-md chart-container flex items-start pt-5 justify-center">
            {!! $sexChart->container() !!}
        </article>

        <article class="border-red-500 border-2 rounded-md chart-container flex items-start pt-5 justify-center">
            {!! $ageChart->container() !!}
        </article>

        <article class="border-red-500 border-2 rounded-md chart-container flex items-start pt-5 justify-center">
            {!! $civilStatusChart->container() !!}
        </article>

        <article class="border-red-500 border-2 rounded-md chart-container flex items-start pt-5 justify-center">
            {!! $pwdStatusChart->container() !!}
        </article>
    </section>

    <header class="w-full bg-blue-700 flex items-center p-2 justify-between">
        <h1 class="text-lg text-white w-[60%] text-end">List of Residents with Disabilities</h1>
        <div class="flex gap-x-2">
            <a href="/super-admin/dashboard/baranggay/add-pwd" class="normal-button">Add PWD <span class="font-bold text-lg">+</span></a>
            <a href="/people-list-within-baranggay/pdf/{{ $baranggay->id }}" class="normal-button">Download List</a>
        </div>
    </header>

    <article class="bg-[#0d99ff] w-full flex items-center p-2 justify-end gap-x-2">
        <form action="{{ route('baranggay-report', $baranggay->id) }}" method="GET" class="relative p-2 w-fit ">
            <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
            <input type="text" class="search-box w-80" placeholder="Search person..." name="search_person">
        </form>

        <form action="{{ route('baranggay-report', $baranggay->id) }}">
            <select name="sort_disability_type" class="normal-button" onchange="this.form.submit()">
                <option selected disabled>-- Sort By Disability Type --</option>
                <option value="">All</option>
                <option value="Visual Impairment" @selected($sortedDisability === 'Visual Impairment')>Visual Impairment</option>
                <option value="Hearing Impairment" @selected($sortedDisability === 'Hearing Impairment')>Hearing Impairment</option>
                <option value="Learning Disabilities" @selected($sortedDisability === 'Learning Disabilities')>Learning Disabilities</option>
                <option value="Speech and Language Impairment" @selected($sortedDisability === 'Speech and Language Impairment')>Speech and Language Impairment</option>
                <option value="Intellectual Disabilities" @selected($sortedDisability === 'Intellectual Disabilities')>Intellectual Disabilities</option>
                <option value="Mobility Impairment" @selected($sortedDisability === 'Mobility Impairment')>Mobility Impairment</option>
                <option value="Psycho-Social Disabilities" @selected($sortedDisability === 'Psycho-Social Disabilities')>Psycho-Social Disabilities</option>
                <option value="Multiple Disabilities" @selected($sortedDisability === 'Multiple Disabilities')>Multiple Disabilities</option>
                <option value="Other Disabilities" @selected($sortedDisability === 'Other Disabilities')>Other Disabilities</option>
            </select>
        </form>

        <form action="{{ route('baranggay-report', $baranggay->id) }}">
            <select name="sort_status" class="normal-button" onchange="this.form.submit()">
                <option selected disabled>-- Sort By Status --</option>
                <option value="">All</option>
                <option value="Active" @selected($sortedByStatus === 'Active')>Active</option>
                <option value="Moved" @selected($sortedByStatus === 'Moved')>Moved</option>
                <option value="Deceased" @selected($sortedByStatus === 'Deceased')>Deceased</option>
            </select>
        </form>

        <form action="{{ route('baranggay-report', $baranggay->id) }}">
            <select name="sort" class="normal-button" onchange="this.form.submit()">
                <option selected disabled>-- Sort By --</option>
                <option value="id" @selected($sort === 'id')>ID</option>
                <option value="name" @selected($sort === 'name')>Name</option>
                <option value="assisted" @selected($sort === 'assisted')>Assisted</option>
            </select>
        </form>
    </article>

    <section class="p-10">
        <table class="border-collapse border border-gray-400 rounded-lg w-full">
            <thead>
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Person with Disabilities</th>
                    <th class="text-sm font-bold">Types of Disabilities</th>
                    <th class="text-sm font-bold">Assisted</th>
                    <th class="text-sm font-bold">Status</th>
                    <th class="text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (session('message'))
                    <h1 class="w-full p-3 text-sm bg-green-500 rounded-lg mb-3">{{ session('message') }}</h1>
                @endif
                @foreach ($persons as $person)
                    @if ($person->present_baranggay === $baranggay->baranggay_name)
                    @php
                        $visualImpairment = explode(', ', $person->disabilityType->visual_impairment);
                        $learningDisabilities = explode(', ', $person->disabilityType->learning_disabilities);
                        $hearingImpairment = explode(', ', $person->disabilityType->hearing_impairment);
                        $speechLanguageImpairment = explode(', ', $person->disabilityType->speech_language_impairment);
                        $intellectualDisabilities = explode(', ', $person->disabilityType->intellectual_disabilities);
                        $mobilityImpairment = explode(', ', $person->disabilityType->mobility_impairment);
                        $psychoSocialDisabilities = explode(', ', $person->disabilityType->psycho_social_disabilities);
                        $multipleDisabilities = explode(', ', $person->disabilityType->multiple_disabilities);
                        $otherDisabilities = explode(', ', $person->disabilityType->other_disabilities);
                    @endphp
                    <tr>
                        <td class="border border-gray-300 text-center">{{ $person->id }}</td>
                        <td class="border border-gray-300 text-center">{{ $person->full_name }}</td>
                        <td class="border border-gray-300 text-center">
                            @if (count($visualImpairment) > 0)
                                @foreach ($visualImpairment as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($learningDisabilities) > 0)
                                @foreach ($learningDisabilities as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($hearingImpairment) > 0)
                                @foreach ($hearingImpairment as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($speechLanguageImpairment) > 0)
                                @foreach ($speechLanguageImpairment as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($intellectualDisabilities) > 0)
                                @foreach ($intellectualDisabilities as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($mobilityImpairment) > 0)
                                @foreach ($mobilityImpairment as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($psychoSocialDisabilities) > 0)
                                @foreach ($psychoSocialDisabilities as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($multipleDisabilities) > 0)
                                @foreach ($multipleDisabilities as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                            @if (count($otherDisabilities) > 0)
                                @foreach ($otherDisabilities as $disability)
                                    <p class="text-sm">{{ $disability }}</p>
                                @endforeach
                            @endif
                        </td>
                        <td class="border border-gray-300 text-center">{{ $person->assisted ? 'Yes' : 'No' }}</td>
                        <td class="border border-gray-300 text-center">{{ $person->status }}</td>
                        <td class="border border-gray-300 text-center">
                            <a href="/super-admin/dashboard/baranggay/edit-pwd/{{ $person->id }}" class="normal-button">Edit</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </section>

    {!! $sexChart->script() !!}
    {!! $ageChart->script() !!}
    {!! $civilStatusChart->script() !!}
    {!! $pwdStatusChart->script() !!}
</body>

</html>
