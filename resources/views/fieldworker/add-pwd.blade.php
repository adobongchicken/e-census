<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @vite('resources/css/app.css')
    <title>Create PWD Information</title>
</head>

<body class="flex items-center justify-center py-10">
    <form action="/field-worker/pwd/create/store" method="POST" class="w-[60%]" enctype="multipart/form-data">
        @csrf
        @method('POST')
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
                <x-input-box type="text" name="last_name" :value="old('last_name')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">First Name *</label>
                <x-input-box type="text" name="first_name" :value="old('first_name')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Middle Name *</label>
                <x-input-box type="text" name="middle_name" :value="old('middle_name')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present House *</label>
                <x-input-box type="text" name="present_house" :value="old('present_house')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present Sitio *</label>
                <x-input-box type="text" name="present_sitio" :value="old('present_sitio')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present Barangay *</label>
                <x-input-box type="text" name="present_baranggay" :value="old('present_baranggay')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present City *</label>
                <x-input-box type="text" name="present_city" :value="old('present_city')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Present Province *</label>
                <x-input-box type="text" name="present_province" :value="old('present_province')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province House *</label>
                <x-input-box type="text" name="province_house" :value="old('province_house')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province Sitio *</label>
                <x-input-box type="text" name="province_sitio" :value="old('province_sitio')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province Barangay *</label>
                <x-input-box type="text" name="province_baranggay" :value="old('province_baranggay')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province City *</label>
                <x-input-box type="text" name="province_city" :value="old('province_city')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Province Province *</label>
                <x-input-box type="text" name="province_province" :value="old('province_province')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-40 text-sm font-medium">Sex *</label>
                <select name="sex" class="border-2 border-red-700 text-sm rounded-lg px-3 py-1 cursor-pointer outline-none">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </article>

            <article class="flex items- gap-5">
                <label class="w-40 text-sm font-medium">Civil Status *</label>

                <div class="flex items-center gap-x-1">
                    <x-input-box type="checkbox" name="civil_status" id="married" value="Married" />
                    <label for="married" class="text-sm">Married</label>
                </div>

                <div class="flex items-center gap-x-1">
                    <x-input-box type="checkbox" name="civil_status" id="single" value="Single"/>
                    <label for="single" class="text-sm">Single</label>
                </div>

                <div class="flex items-center gap-x-1">
                    <x-input-box type="checkbox" name="civil_status" id="widowed" value="Widowed"/>
                    <label for="widowed" class="text-sm">Widowed</label>
                </div>
            </article>  

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Date of Birth *</label>
                <x-input-box type="date" name="date_of_birth" :value="old('date_of_birth')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Place of Birth *</label>
                <x-input-box type="text" name="place_of_birth" :value="old('place_of_birth')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Contact No *</label>
                <x-input-box type="text" name="contact_no" :value="old('contact_no')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Email Address *</label>
                <x-input-box type="email" name="email" :value="old('email')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Height *</label>
                <x-input-box type="text" name="height" :value="old('height')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Weight *</label>
                <x-input-box type="text" name="weight" :value="old('weight')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Religion *</label>
                <x-input-box type="text" name="religion" :value="old('religion')"/>
            </article>
            <button id="button-1" type="button" class="primary-button w-32 self-center">Next</button>
        </aside>

       <aside class="flex flex-col gap-4 px-10 educational-attainment hidden">
            <h1 class="text-xl font-bold">Educational Attainment</h1>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Elementary School *</label>
                <x-input-box type="text" name="elementary_school" :value="old('elementary_school')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Elementary School Address *</label>
                <x-input-box type="text" name="elementary_school_address" :value="old('elementary_school_address')"/>
            </article>
            
            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">High School *</label>
                <x-input-box type="text" name="high_school" :value="old('high_school')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">High School Address *</label>
                <x-input-box type="text" name="high_school_address" :value="old('high_school_address')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Vocational School *</label>
                <x-input-box type="text" name="vocational_school" :value="old('vocational_school')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Vocational Address *</label>
                <x-input-box type="text" name="vocational_address" :value="old('vocational_address')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">College School *</label>
                <x-input-box type="text" name="college_school" :value="old('college_school')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">College Address *</label>
                <x-input-box type="text" name="college_address" :value="old('college_address')"/>
            </article>

            <button id="button-2" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-2" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside>

        <aside class="flex flex-col gap-4 px-10 employment-record hidden">
            <article class="flex items-center justify-between">
                <h1 class="text-xl font-bold">Employment Record</h1>
                <button class="primary-button" type="button" id="add-employment" onclick="generateEmploymentForm()">Add Employment</button>
            </article>
            <section class="flex flex-col gap-4" id="employment-record""></section>
            <button id="button-3" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-3" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside>

        <aside class="flex flex-col gap-4 px-10 items-start disability-type hidden">
            <h1 class="text-xl font-bold">Disability Type</h1>

            <section class="flex items-center justify-between w-full">
                <article class="flex flex-col gap-2 items-start justify-start">
                    <h1 class="font-bold text-sm">Visual Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="visual_impairment[]" value="Blindness">
                        <label class="text-sm font-medium">Blindness</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="visual_impairment[]" value="Low Vision">
                        <label class="text-sm font-medium">Low Vision</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[43%] items-start justify-start">
                    <h1 class="font-bold text-sm">Speech/Language Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="speech_language_impairment[]" value="Difficulty Speaking">
                        <label class="text-xs font-medium">Difficulty Speaking (Stuttering, Dysarthria)</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="speech_language_impairment[]" value="Non-verbal">
                        <label class="text-sm font-medium">Non-verbal</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 items-start justify-start">
                    <h1 class="font-bold text-sm">Learning Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="Dyslexia">
                        <label class="text-sm font-medium">Dyslexia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="learning_disabilities[]" value="ADHD">
                        <label class="text-sm font-medium">ADHD</label>
                    </div>
                </article>
            </section>

            <section class="flex items-center justify-between w-full">
                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Hearing Impairment</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="hearing_impairment[]" value="Blindness">
                        <label class="text-sm font-medium">Blindness</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="hearing_impairment[]" value="Low Vision">
                        <label class="text-sm font-medium">Low Vision</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2 w-[45%]">
                    <h1 class="font-bold text-sm">Intellectual Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Down Syndrome">
                        <label class="text-sm font-medium">Down Syndrome</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Development Delay">
                        <label class="text-sm font-medium">Development Delay</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="intellectual_disabilities[]" value="Autism Spectrum Disorder">
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
                        <input type="checkbox" name="mobility_impairment[]" value="Paraplegia">
                        <label class="text-sm font-medium">Paraplegia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Quadriplegia">
                        <label class="text-sm font-medium">Quadriplegia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Amputation">
                        <label class="text-sm font-medium">Amputation</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="mobility_impairment[]" value="Musculoskeletal Disabilities">
                        <label class="text-sm font-medium text-wrap w-1/2">Musculoskeletal Disabilities</label>
                    </div>                    
                </article>

                <article class="flex flex-col gap-2 w-[35%]">
                    <h1 class="font-bold text-sm">Psycho Social Disabilities</h1>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Depression">
                        <label class="text-sm font-medium">Depression</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Anxiety Disorder">
                        <label class="text-sm font-medium">Anxiety Disorder</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Schizophrenia">
                        <label class="text-sm font-medium">Schizophrenia</label>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="psycho_social_disabilities[]" value="Bipolar Disorder">
                        <label class="text-sm font-medium">Bipolar Disorder</label>
                    </div>
                </article>

                <article class="flex flex-col gap-2">
                    <h1 class="font-bold text-sm">Multiple Disabilities (different categories)</h1>
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1">
                    </div>
                    <div class="flex items-center gap-1">
                        <label class="text-sm font-medium">Specify: </label>
                        <input type="text" name="multiple_disabilities[]" class="border-b border-black outline-none text-xs p-1">
                    </div>
                    <h1 class="font-bold text-sm">Other Disability</h1>
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
                <x-input-box type="text" name="guardian_full_name" :value="old('guardian_full_name')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-60 text-sm font-medium">Guardian Phone Number *</label>
                <x-input-box type="text" name="guardian_phone_number" :value="old('guardian_phone_number')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-60 text-sm font-medium">Relationship *</label>
                <x-input-box type="text" name="guardian_relationship" :value="old('guardian_relationship')"/>
            </article>

            <button id="button-5" type="button" class="primary-button w-32 self-center">Next</button>
            <button id="cancel-5" type="button" class="primary-button w-32 self-center bg-red-700">Back</button>

        </aside>

        <aside class="flex flex-col gap-4 px-10 final-form hidden">

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Account ID: </label>
                <x-input-box type="text" name="account_id" :value="old('account_id', $generateId)"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Resident ID: </label>
                <x-input-box type="text" name="resident_id" :value="old('resident_id')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Barangay ID: </label>
                <x-input-box type="text" name="baranggay_id" :value="old('baranggay_id')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Status </label>
                <select name="status" class="input-box border-red-700">
                    <option value="Active">Active</option>
                    <option value="Moved">Moved</option>
                    <option value="Deceased">Deceased</option>
                </select>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Date of Submission: </label>
                <x-input-box type="date" name="date_submission" :value="old('date_submission')"/>
            </article>

            <article class="flex items-center">
                <label class=" w-52 text-sm font-medium">Submission Details: </label>
                <x-input-box type="text" name="submission_details" :value="old('submission_details')" />
            </article>
            <input type="text" name="assisted_by" value="{{ old('assisted_by', Auth::user()->full_name) }}" hidden>
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
        generateEmploymentForm()

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
