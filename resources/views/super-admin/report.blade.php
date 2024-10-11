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
</head>

<body>
    <header class="w-full bg-red-600 flex items-center justify-between ">
        <article class="flex items-center p-2 w-1/2 gap-3">
            <article class="relative bg-white p-2 rounded-lg">
                <a href="/super-admin/dashboard"><img src="{{ asset('assets/left.png')}} " alt="Back Image" class="w-5"></a>
            </article>
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
            <h1 class="text-white text-xl font-bold text-end w-full">{{ $baranggay->baranggay_name }}</h1>
        </article>

        <h1 class="text-white text-lg font-bold px-10 py-6 border-2 border-red-800 rounded-md">{{ now()->format('M - d - Y') }}</h1>
    </header>
    
    <section class="flex items-center justify-around py-5 h-72">
        <article class="border-red-500 border-2 rounded-md h-full w-[24%] flex items-start pt-5 justify-center">
            {!! $sexChart->container() !!}
        </article>

        <article class="border-red-500 border-2 rounded-md h-full w-[24%] flex items-start pt-5 justify-center">
            {!! $ageChart->container() !!}
        </article>

        <article class="border-red-500 border-2 rounded-md h-full w-[24%] flex items-start pt-5 justify-center">
            {!! $civilStatusChart->container() !!}
        </article>

        <article class="border-red-500 border-2 rounded-md h-full w-[24%] flex items-start pt-5 justify-center">
            {!! $pwdStatusChart->container() !!}
        </article>
    </section>
    
    <header class="w-full">
        <article class="bg-blue-700 w-full flex items-center p-2 justify-between">
            <h1 class="text-lg text-white w-[60%] text-end">List of Residents with Disabilities</h1>
            <div class="flex gap-x-2">
                <a href="/super-admin/dashboard/baranggay/add-pwd" class="normal-button flex items-center justify-center gap-2 py-1">Add PWD <span class="font-bold text-lg">+</span></a>
                <a href="/people-list-within-baranggay/pdf/{{ $baranggay->id }}" class="normal-button flex items-center justify-center gap-2 py-1">Download List</a>
            </div>
        </article>

        <article class="bg-[#0d99ff] w-full flex items-center p-2 justify-end gap-x-2">
            <form action="{{ route('baranggay-report', $baranggay->id) }}" method="GET" class="relative p-2 w-fit ">
                <img src="{{ asset('assets/search.png') }}" alt="Search Logo" class="w-3 absolute right-5 top-4">
                <input type="text" class="search-box w-80" placeholder="Search person..." name="search_person">
            </form>

            <form action="{{ route('baranggay-report', $baranggay->id) }}">
                <select name="sort_disability_type" class="normal-button" onchange="this.form.submit()">
                    <option selected disabled>-- Sort By Disablity Type --</option>
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
    </header>

    <section class="p-10">
        <table class="border-collapse border border-gray-400 rounded-lg w-full">
            <thead>
                <tr>
                    <th class="text-sm font-bold">ID</th>
                    <th class="text-sm font-bold">Person with Disabilitities</th>
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

                        $allDisabilities = array_merge(
                            $visualImpairment,
                            $learningDisabilities,
                            $hearingImpairment,
                            $speechLanguageImpairment,
                            $intellectualDisabilities,
                            $mobilityImpairment,
                            $psychoSocialDisabilities,
                            $multipleDisabilities,
                            $otherDisabilities
                        );

                        $allDisabilities = array_filter($allDisabilities); 
                    @endphp 
                        <tr>
                            <td class="text-center"> {{ $person->id }} </td>
                            <td class="text-center">{{ $person->first_name }} {{ $person->last_name }}</td>
                            <td class="text-center">{{implode(', ', $allDisabilities )}}</td>
                            <td class="text-center">Assisted by {{ $person->submittedForm->assisted_by }} </td>
                            <td class="text-center">{{ $person->submittedForm->status}}</td>
                            <td>
                                <div class="flex items-center justify-center gap-x-3">
                                    <a href="/super-admin/dashboard/baranggay/pwd/{{ $person->id }}/view"><img src="{{ asset('assets/eye.png')}}" alt="View Image" class="w-5"></a>
                                    <a href="/super-admin/dashboard/baranggay/pwd/{{ $person->id }}/edit"><img src="{{ asset('assets/pencil.png')}}" alt="Edit Image" class="w-5"></a>
                                    <form action="/super-admin/dashboard/baranggay/pwd/{{ $person->id }}/delete" method="POST" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button class="flex items-center justify-center"><img src="{{ asset('assets/trash.png')}}" alt="Delete Image" class="w-5"></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <article class="flex items-center justify-center gap-3 py-3">
            {{ $persons->links()}}
        </article>
    </section>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this person? This action cannot be undone.');
        }
    </script>
    <script src="{!! $sexChart->cdn() !!}"></script>
    <script src="{!! $ageChart->cdn() !!}"></script>
    <script src="{!! $civilStatusChart->cdn() !!}"></script>
    <script src="{!! $pwdStatusChart->cdn() !!}"></script>
    {!! $sexChart->script() !!}
    {!! $ageChart->script() !!}
    {!! $civilStatusChart->script() !!}
    {!! $pwdStatusChart->script() !!}
</body>

</html>
