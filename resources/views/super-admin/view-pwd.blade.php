<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title>View PWD</title>
</head>

<body class="bg-gray-100">
<header class="w-full fixed top-0 left-0 z-10">
    <article class="w-full bg-red-600 flex items-center justify-between px-2 pr-10 p-3">
    
       <div class="flex items-center gap-2">
       <article class="relative bg-white p-2 rounded-lg">
    <a href="javascript:history.back()" class="flex items-center">
        <img src="{{ asset('assets/left.png') }}" alt="Back Image" class="w-5">
        <span class="ml-2 text-gray-800"></span>
    </a>
    </article>

            <h1 class="text-white text-xl font-medium">{{ $person->first_name}} {{ $person->last_name}}</h1>
        </div>
        <a href="/pwd-data/pdf/{{ $person->id }}" class="normal-button">Download Data</a>
    </header>

   
    <main class="px-8 py-10 ">
    <article p-10>
        <!-- Container for Double Column Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Personal Information Section -->
            <section class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-[#f24822] text-lg font-bold mb-4">Personal Information</h1>
                
                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Last Name</label>
                    <x-input-box type="text" :value="old('last_name', $person->last_name)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">First Name</label>
                    <x-input-box type="text" :value="old('first_name', $person->first_name)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Middle Name</label>
                    <x-input-box type="text" :value="old('middle_name', $person->middle_name)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Present House</label>
                    <x-input-box type="text" :value="old('present_house', $person->present_house)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Present Sitio</label>
                    <x-input-box type="text" :value="old('present_sitio', $person->present_sitio)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Present Barangay</label>
                    <x-input-box type="text" :value="old('present_baranggay', $person->present_baranggay)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Present City</label>
                    <x-input-box type="text" :value="old('present_city', $person->present_city)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Present Province</label>
                    <x-input-box type="text" :value="old('present_province', $person->present_province)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Province House</label>
                    <x-input-box type="text" :value="old('province_house', $person->province_house)" />
                </article>

                
                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Province Sitio</label>
                    <x-input-box type="text" :value="old('province_sitio', $person->province_sitio)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Province Barangay</label>
                    <x-input-box type="text" :value="old('province_baranggay', $person->province_baranggay)" />
                </article>
                
                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Province City</label>
                    <x-input-box type="text" :value="old('province_city', $person->province_city)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Province Province</label>
                    <x-input-box type="text" :value="old('province_province', $person->province_province)" />
                </article>

                 <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Sex</label>
                    <x-input-box type="text" :value="old('sex', $person->sex)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Civil Status</label>
                    <x-input-box type="text" :value="old('civil_status', $person->civil_status)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Date of Birth</label>
                    <x-input-box type="text" :value="old('date_of_birth', $person->date_of_birth)" />
                </article>
                
                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Contact No</label>
                    <x-input-box type="text" :value="old('contact_no', $person->contact_no)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Email Address</label>
                    <x-input-box type="text" :value="old('email', $person->email)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Height</label>
                    <x-input-box type="text" :value="old('height', $person->height)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Weight</label>
                    <x-input-box type="text" :value="old('weight', $person->weight)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Religion</label>
                    <x-input-box type="text" :value="old('religion', $person->religion)" />
                </article>

                <h1 class="text-[#f24822] text-lg font-bold mb-4 mt-4">Guardian Information</h1>
                
                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Guardian Name</label>
                    <x-input-box type="text" :value="old('guardian_full_name', $person->guardians->guardian_full_name)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Guardian Contact</label>
                    <x-input-box type="text" :value="old('guardian_phone_number', $person->guardians->guardian_phone_number)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Guardian Relationship</label>
                    <x-input-box type="text" :value="old('guardian_relationship', $person->guardians->guardian_relationship)" />
                </article>
                
            </section>

            <!-- Education, Guardian, and Disability Info -->
            <section class="bg-white shadow-md rounded-lg p-6">

            <article class="flex items-center justify-center mt-5">
                <img src="{{ asset('pwd-images/' . $person->disabilityType->profile) }}" alt="Profile" class="w-[300px] h-[300px] rounded-lg">
            </article>

                <h1 class="text-[#f24822] text-lg font-bold mb-4">Educational Attainment</h1>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Elementary School</label>
                    <x-input-box type="text" :value="old('elementary_school', $person->educationalAttainment->elementary_school)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Elementary School Address</label>
                    <x-input-box type="text" :value="old('elementary_school_address', $person->educationalAttainment->elementary_school_address)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">High School</label>
                    <x-input-box type="text" :value="old('high_school', $person->educationalAttainment->high_school)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">High School Address</label>
                    <x-input-box type="text" :value="old('high_school_address', $person->educationalAttainment->high_school_address)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Vocational School</label>
                    <x-input-box type="text" :value="old('vocational_school', $person->educationalAttainment->vocational_school)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Vocational Address</label>
                    <x-input-box type="text" :value="old('vocational_address', $person->educationalAttainment->vocational_address)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">College School</label>
                    <x-input-box type="text" :value="old('college_school', $person->educationalAttainment->college_school)" />
                </article>

                <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">College Address</label>
                    <x-input-box type="text" :value="old('college_address', $person->educationalAttainment->college_address)" />
                </article>

              
                <h1 class="text-[#f24822] text-lg font-bold mb-4 mt-4">Employment Record</h1>

            @foreach ($person->employmentRecord as $index => $record)
                @if (!is_null($record->duration) || !is_null($record->company_name) || !is_null($record->company_address))
                <article class="flex items-center mb-3">
                <label class="w-1/3 font-medium"> Duration {{ $index + 1 }} </label>
                        <x-input-box type="text" :value="old('duration', $record->duration)" />
                    </article>

                    <article class="flex items-center mb-3">
                    <label class="w-1/3 font-medium">Company Name {{ $index + 1 }}</label>
                        <x-input-box type="text" :value="old('company_name', $record->company_name)" />
                    </article>

                    <article class="flex items-center mb-3">
                <label class="w-1/3 font-medium">Company Address {{ $index + 1 }}</label>
                        <x-input-box type="text" :value="old('company_address', $record->company_address)" />
                    </article>
                @endif
            @endforeach  

                <h1 class="text-[#f24822] text-lg font-bold mb-4 mt-4">Disability Type</h1>
                <article class="w-full flex flex-col gap-1">
                    <h1 class="font-medium text-lg">{{ $person->disabilityType->visual_impairment}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->speech_language_impairment}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->learning_disabilities}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->hearing_impairment}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->intellectual_disabilities}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->mobility_impairment}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->psycho_social_disabilities}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->multiple_disabilities}}</h1>
                <h1 class="font-medium text-lg">{{ $person->disabilityType->other_disabilities}}</h1>
                </article>
            </section>
        </div>
        </article>
    </main>
</body>

</html>
