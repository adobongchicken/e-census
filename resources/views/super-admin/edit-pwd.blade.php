<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <title>Edit PWD Information</title>
</head>

<body class="flex items-center justify-center py-10">
    <form action="/super-admin/dashboard/edit-pwd/{{ $person->id }}/update" method="POST" class="w-[60%]" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <header class="flex items-center bg-blue-700 p-2 rounded-md mb-5">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo Image" class="w-16">
            </div>
            <h1 class="text-white text-lg font-medium w-full text-center form-title">Person with Disability Info</h1>
        </header>
        @if ($errors->any())
            <div class="bg-red-100 text-red-500 p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <aside class="flex flex-col gap-4 px-10 personal-info">
            <h1 class="text-xl font-bold">Personal Information</h1>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Last Name *</label>
                <x-input-box type="text" name="last_name" value="{{ $person->last_name }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">First Name *</label>
                <x-input-box type="text" name="first_name" value="{{ $person->first_name }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Middle Name *</label>
                <x-input-box type="text" name="middle_name" value="{{ $person->middle_name }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present House *</label>
                <x-input-box type="text" name="present_house" value="{{ $person->present_house }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present Sitio *</label>
                <x-input-box type="text" name="present_sitio" value="{{ $person->present_sitio }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present Barangay *</label>
                <x-input-box type="text" name="present_baranggay" value="{{ $person->present_baranggay }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present City *</label>
                <x-input-box type="text" name="present_city" value="{{ $person->present_city }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present Province *</label>
                <x-input-box type="text" name="present_province" value="{{ $person->present_province }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province House *</label>
                <x-input-box type="text" name="province_house" value="{{ $person->province_house }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province Sitio *</label>
                <x-input-box type="text" name="province_sitio" value="{{ $person->province_sitio }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province Barangay *</label>
                <x-input-box type="text" name="province_baranggay" value="{{ $person->province_baranggay }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province City *</label>
                <x-input-box type="text" name="province_city" value="{{ $person->province_city }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province Province *</label>
                <x-input-box type="text" name="province_province" value="{{ $person->province_province }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-40 text-sm font-medium">Sex *</label>
                <select name="sex" class="border-2 border-red-700 text-sm rounded-lg px-3 py-1 cursor-pointer outline-none">
                    <option value="Male" {{ $person->sex  === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $person->sex  === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </article>

            <article class="flex items- gap-5">
                <label class="w-40 text-sm font-medium">Civil Status *</label>

                <div class="flex items-center gap-x-1">
                    <input type='checkbox' name="civil_status" id="married" value="Married" @checked($person->civil_status === 'Married')>
                    <label for="married" class="text-sm">Married</label>
                </div>

                <div class="flex items-center gap-x-1">
                    <input type='checkbox' name="civil_status" id="single" value="Single" @checked($person->civil_status === 'Single')>
                    <label for="single" class="text-sm">Single</label>
                </div>

                <div class="flex items-center gap-x-1">
                    <input type='checkbox' name="civil_status" id="widowed" value="Widowed" @checked($person->civil_status === 'Widowed')>
                    <label for="widowed" class="text-sm">Widowed</label>
                </div>
            </article>  

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Date of Birth *</label>
                <x-input-box type="date" name="date_of_birth" value="{{ $person->date_of_birth }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Place of Birth *</label>
                <x-input-box type="text" name="place_of_birth" value="{{ $person->place_of_birth }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Contact No *</label>
                <x-input-box type="text" name="contact_no" value="{{ $person->contact_no }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Email Address *</label>
                <x-input-box type="email" name="email" value="{{ $person->email }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Height *</label>
                <x-input-box type="text" name="height" value="{{ $person->height }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Weight *</label>
                <x-input-box type="text" name="weight" value="{{ $person->weight }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Religion *</label>
                <x-input-box type="text" name="religion" value="{{ $person->religion }}"/>
            </article>
            <button id="button-1" type="button" class="primary-button w-32 self-center">Next</button>
        </aside>

       <aside class="flex flex-col gap-4 px-10 educational-attainment hidden">
            <h1 class="text-xl font-bold">Educational Attainment</h1>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Elementary School *</label>
                <x-input-box type="text" name="elementary_school" value="{{ $person->educationalAttainment->elementary_school }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Elementary School Address *</label>
                <x-input-box type="text" name="elementary_school_address" value="{{ $person->educationalAttainment->elementary_school_address }}"/>
            </article>
            
            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">High School *</label>
                <x-input-box type="text" name="high_school" value="{{ $person->educationalAttainment->high_school }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">High School Address *</label>
                <x-input-box type="text" name="high_school_address" value="{{ $person->educationalAttainment->high_school_address }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Vocational School *</label>
                <x-input-box type="text" name="vocational_school" value="{{ $person->educationalAttainment->vocational_school }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Vocational Address *</label>
                <x-input-box type="text" name="vocational_address" value="{{ $person->educationalAttainment->vocational_address }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">College School *</label>
                <x-input-box type="text" name="college_school" value="{{ $person->educationalAttainment->college_school }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">College Address *</label>
                <x-input-box type="text" name="college_address" value="{{ $person->educationalAttainment->college_address }}"/>
            </article>

            <button id="button-2" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-2" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside>

        <aside class="flex flex-col gap-4 px-10 employment-record hidden">
            <article class="flex items-center justify-between">
                <h1 class="text-xl font-bold">Employment Record</h1>
                {{-- <button class="primary-button" type="button" id="add-employment" onclick="generateEmploymentForm()">Add Employment</button> --}}
            </article>

            <section class="flex flex-col gap-4" id="employment-record">
                @foreach ($person->employmentRecord as $index => $record)
                    @if (!is_null($record->duration) || !is_null($record->company_name) || !is_null($record->company_address))
                        <article class="flex items-center">
                            <label class="w-52 text-sm font-medium"> Duration {{ $index + 1}} </label>
                            <input type="text" class="input-box border-red-700" name="duration[]" value="{{ $record->duration }}">
                        </article>

                        <article class="flex items-center">
                            <label class="w-52 text-sm font-medium"> Company Name {{ $index + 1}} </label>
                            <input type="text" class="input-box border-red-700" name="company_name[]" value="{{ $record->company_name }}">
                        </article>

                        <article class="flex items-center">
                            <label class="w-52 text-sm font-medium"> Company Address {{ $index + 1}} </label>
                            <input type="text" class="input-box border-red-700" name="company_address[]" value="{{ $record->company_address }}">
                        </article>
                    @endif
                @endforeach
            </section>
            <button id="button-3" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-3" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside>

        <aside class="flex flex-col gap-4 px-10 items-start disability-type hidden">
            <h1 class="text-xl font-bold">Disability Type</h1>

            <section class="flex items-center justify-between w-full">
                <article class="flex flex-col gap-2 items-start justify-start">
                    <h1 class="font-bold text-sm">Visual Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="visual_impairment[]" value="Blindness" @checked(in_array('Blindness', $visualImpairment))>
                        <label class="text-sm font-medium">Blindness</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="visual_impairment[]" value="Low Vision" @checked(in_array('Low Vision', $visualImpairment))>
                        <label class="text-sm font-medium">Low Vision</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[43%] items-start justify-start">
                    <h1 class="font-bold text-sm">Speech/Language Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="speech_language_impairment[]" value="Difficulty Speaking" @checked(in_array('Difficulty Speaking', $speechLanguageImpairment))>
                        <label class="text-xs font-medium">Difficulty Speaking (Stuttering, Dysarthria)</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="speech_language_impairment[]" value="Non-verbal" @checked(in_array('Non-verbal', $speechLanguageImpairment))>
                        <label class="text-sm font-medium">Non-verbal</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 items-start justify-start">
                    <h1 class="font-bold text-sm">Learning Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="Dyslexia" @checked(in_array('Dyslexia', $learningDisabilities))>
                        <label class="text-sm font-medium">Dyslexia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="ADHD" @checked(in_array('ADHD', $learningDisabilities))>
                        <label class="text-sm font-medium">ADHD</label>
                    </div>
                </article>
            </section>

            <section class="flex items-center justify-between w-full">
                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Hearing Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="hearing_impairment[]" value="Blindness" @checked(in_array('Blindness', $hearingImpairment))>
                        <label class="text-sm font-medium">Blindness</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="hearing_impairment[]" value="Low Vision" @checked(in_array('Low Vision', $hearingImpairment))>
                        <label class="text-sm font-medium">Low Vision</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[45%]">
                    <h1 class="font-bold text-sm">Intellectual Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Down Syndrome" @checked(in_array('Down Syndrome', $intellectualDisabilities))>
                        <label class="text-sm font-medium">Down Syndrome</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Development Delay" @checked(in_array('Development Delay', $intellectualDisabilities))>
                        <label class="text-sm font-medium">Development Delay</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Autism Spectrum Disorder" @checked(in_array('Autism Spectrum Disorder', $intellectualDisabilities))>
                        <label class="text-sm font-medium">Autism Spectrum Disorder</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[145px]">
                    
                </article>
            </section>

            <section class="flex items-center justify-between w-full">
                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Mobility Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Paraplegia" @checked(in_array('Paraplegia', $mobilityImpairment))>
                        <label class="text-sm font-medium">Paraplegia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Quadriplegia" @checked(in_array('Quadriplegia', $mobilityImpairment))>
                        <label class="text-sm font-medium">Quadriplegia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Amputation" @checked(in_array('Amputation', $mobilityImpairment))>
                        <label class="text-sm font-medium">Amputation</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Musculoskeletal Disabilities" @checked(in_array('Musculoskeletal Disabilities', $mobilityImpairment))>
                        <label class="text-sm font-medium text-wrap w-1/2">Musculoskeletal Disabilities</label>
                    </div>                    
                </article>

                <article class="flex flex-col gap-2 w-[35%]">
                    <h1 class="font-bold text-sm">Psycho Social Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Depression" @checked(in_array('Depression', $psychoSocialDisabilities))>
                        <label class="text-sm font-medium">Depression</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Anxiety Disorder" @checked(in_array('Anxiety Disorder', $psychoSocialDisabilities))>
                        <label class="text-sm font-medium">Anxiety Disorder</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Schizophrenia" @checked(in_array('Schizophrenia', $psychoSocialDisabilities))>
                        <label class="text-sm font-medium">Schizophrenia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Bipolar Disorder" @checked(in_array('Bipolar Disorder', $psychoSocialDisabilities))>
                        <label class="text-sm font-medium">Bipolar Disorder</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Multiple Disabilities (different categories)</h1>
                    @foreach ($multipleDisabilities as $disability)
                        <div class="flex items-center gap-1">
                            <label class="text-sm font-medium">Specify: </label>
                            <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1" value="{{ $disability }}">
                        </div>    
                    @endforeach
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1">
                    </div>
                    <h1 class="font-bold text-sm">Other Disability</h1>
                    @foreach ($otherDisabilities as $disability)
                        <div class="flex items-center gap-1">
                            <label class="text-sm font-medium">Specify: </label>
                            <input type="text" name="other_disabilities[]" class="border-b border-black outline-none text-xs p-1" value="{{ $disability }}">
                        </div>
                    @endforeach
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="other_disabilities[]" class="border-b border-black outline-none text-xs p-1">
                    </div>
                </article>
            </section>
            <input type="file" name="profile" accept=".png, .jpg, .jpeg" class="input-box border-red-700 w-64">
            <button id="button-4" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-4" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside> 

        <aside class="flex flex-col gap-4 px-10 guardian-form hidden">
            <article class="flex items-center">
                <label class=" w-60 text-sm font-medium">Guardian Full Name *</label>
                <x-input-box type="text" name="guardian_full_name" value="{{ $person->guardians->guardian_full_name }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-60 text-sm font-medium">Guardian Phone Number *</label>
                <x-input-box type="text" name="guardian_phone_number" value="{{ $person->guardians->guardian_phone_number }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-60 text-sm font-medium">Relationship *</label>
                <x-input-box type="text" name="guardian_relationship" value="{{ $person->guardians->guardian_relationship }}"/>
            </article>
            <button id="button-5" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-5" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside>

        <aside class="flex flex-col gap-4 px-10 final-form hidden">

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Account ID: </label>
                <x-input-box type="text" name="account_id" value="{{ $person->submittedForm->account_id}}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Resident ID: </label>
                <x-input-box type="text" name="resident_id" value="{{ $person->submittedForm->resident_id }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Barangay ID: </label>
                <x-input-box type="text" name="baranggay_id" value="{{ $person->submittedForm->baranggay_id }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Status </label>
                <select name="status" class="input-box border-red-700">
                    <option value="Active" @selected( $person->submittedForm->status === 'Active' )>Active</option>
                    <option value="Moved" @selected( $person->submittedForm->status === 'Moved' )>Moved</option>
                    <option value="Deceased" @selected( $person->submittedForm->status === 'Deceased' )>Deceased</option>
                </select>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Date of Submission: </label>
                <x-input-box type="date" name="date_submission" value="{{ $person->submittedForm->date_submission }}"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Submission Details: </label>
                <x-input-box type="text" name="submission_details" value="{{ $person->submittedForm->submission_details }}" />
            </article>
            <input type="text" name="assisted_by" value="{{ $person->submittedForm->assisted_by }}" hidden>
            <button class="primary-button w-32 self-center">Submit</button>
            <button id="cancel-6" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>
        </aside> 
    </form>

    <script>
        const firstButton = document.getElementById('button-1')
        const secondButton = document.getElementById('button-2')
        const thirdButton = document.getElementById('button-3')
        const fourthButton = document.getElementById('button-4')
        const fifthButton = document.getElementById('button-5')

        const secondCancel = document.getElementById('cancel-2')
        const thirdCancel = document.getElementById('cancel-3')
        const fourthCancel = document.getElementById('cancel-4')
        const fifthCancel = document.getElementById('cancel-5')
        const sixthCancel = document.getElementById('cancel-6')

        const addEmploymentButton = document.getElementById('add-employment')
        const employmentFormContainer = document.getElementById('employment-record')

        const personalInformationForm = document.querySelector('.personal-info')
        const educationalAttainmentForm = document.querySelector('.educational-attainment')
        const employmentRecordForm = document.querySelector('.employment-record')
        const disabilityTypeForm = document.querySelector('.disability-type')
        const guardianForm = document.querySelector('.guardian-form')
        const finalForm = document.querySelector('.final-form')

        let count = 1;
        const formTitle = document.querySelector('.form-title')

        const generateEmploymentForm = () => {

            const durationArticle = document.createElement('article')
            const durationInput = document.createElement('input')
            const durationLabel = document.createElement('label')
            durationLabel.innerHTML = `Duration ${count}`

            const companyNameArticle = document.createElement('article')
            const companyNameInput = document.createElement('input')
            const companyNameLabel = document.createElement('label')
            companyNameLabel.innerHTML = `Company Name ${count}`
            
            const companyAddressArticle = document.createElement('article')
            const companyAddressInput = document.createElement('input')
            const companyAddressLabel = document.createElement('label')
            companyAddressLabel.innerHTML = `Company Address ${count}`

            durationArticle.classList.add('article')
            durationLabel.classList.add('label')
            durationInput.classList.add('input-box')
            durationInput.classList.add('border-red-700')

            companyNameArticle.classList.add('article')
            companyNameLabel.classList.add('label')
            companyNameInput.classList.add('input-box')
            companyNameInput.classList.add('border-red-700')

            companyAddressArticle.classList.add('article')
            companyAddressLabel.classList.add('label')
            companyAddressInput.classList.add('input-box')
            companyAddressInput.classList.add('border-red-700')

            durationInput.name = `duration[]`
            companyNameInput.name = `company_name[]`
            companyAddressInput.name = `company_address[]`

            durationArticle.append(durationLabel)
            durationArticle.append(durationInput)

            companyNameArticle.append(companyNameLabel)
            companyNameArticle.append(companyNameInput)

            companyAddressArticle.append(companyAddressLabel)
            companyAddressArticle.append(companyAddressInput)

            employmentFormContainer.appendChild(durationArticle);
            employmentFormContainer.appendChild(companyNameArticle);
            employmentFormContainer.appendChild(companyAddressArticle);

            count++;
        }

        firstButton.addEventListener('click', () => {
            personalInformationForm.classList.add('hidden')
            educationalAttainmentForm.classList.remove('hidden')
        })
        secondButton.addEventListener('click', () => {
            educationalAttainmentForm.classList.add('hidden')
            employmentRecordForm.classList.remove('hidden')
        })
        thirdButton.addEventListener('click', () => {
            employmentRecordForm.classList.add('hidden')
            disabilityTypeForm.classList.remove('hidden')
        })
        fourthButton.addEventListener('click', () => {
            disabilityTypeForm.classList.add('hidden')
            guardianForm.classList.remove('hidden')
        })
        fifthButton.addEventListener('click', () => {
            guardianForm.classList.add('hidden')
            finalForm.classList.remove('hidden')
            formTitle.innerHTML = 'Submission Form'
        })

        secondCancel.addEventListener('click', () => {
            educationalAttainmentForm.classList.add('hidden')
            personalInformationForm.classList.remove('hidden')
        })

        thirdCancel.addEventListener('click', () => {
            educationalAttainmentForm.classList.remove('hidden')
            employmentRecordForm.classList.add('hidden')
        })

        fourthCancel.addEventListener('click', () => {
            employmentRecordForm.classList.remove('hidden')
            disabilityTypeForm.classList.add('hidden')
        })

        fifthCancel.addEventListener('click', () => {
            disabilityTypeForm.classList.remove('hidden')
            guardianForm.classList.add('hidden')
        })

        sixthCancel.addEventListener('click', () => {
            guardianForm.classList.remove('hidden')
            finalForm.classList.add('hidden')
            formTitle.innerHTML = 'Person with Disability Info'
        })

    </script>
</body>

</html>
