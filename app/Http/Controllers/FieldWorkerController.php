<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\BirthdayCashGift;
use App\Models\DisabilityType;
use App\Models\EducationalAttainment;
use App\Models\EmploymentRecord;
use App\Models\Event;
use App\Models\Guardian;
use App\Models\PersonWithDisability;
use App\Models\ProgramAttendance;
use App\Models\SubmittedForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FieldWorkerController extends Controller
{
    public function index(Request $request)
    {
        $persons = PersonWithDisability::with('disabilityType')->where('present_baranggay', '=', Auth::user()->baranggay->baranggay_name)->simplePaginate(7);

        $personQuery = PersonWithDisability::with('disabilityType')->where('present_baranggay', '=', Auth::user()->baranggay->baranggay_name);
        $currentDate = Carbon::now()->format('Y-m-d');
        $todaysEvent = Event::where('date', '=', $currentDate)->get();
        
        $sort = $request->sort;
        $search = $request->search_person;
        $sortByDisabilityType = $request->sort_disability_type;
        $sortByStatus = $request->sort_status;

        if ($search) {
            $personQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($sortByDisabilityType) {
            $personQuery->whereHas('disabilityType', function ($query) use ($sortByDisabilityType) {
                if ($sortByDisabilityType === 'Visual Impairment') {
                    $query->whereNotNull('visual_impairment')->where('visual_impairment', '!=', '');
                } elseif ($sortByDisabilityType === 'Hearing Impairment') {
                    $query->whereNotNull('hearing_impairment')->where('hearing_impairment', '!=', '');
                } elseif ($sortByDisabilityType === 'Learning Disabilities') {
                    $query->whereNotNull('learning_disabilities')->where('learning_disabilities', '!=', '');
                } elseif ($sortByDisabilityType === 'Speech and Language Impairment') {
                    $query->whereNotNull('speech_language_impairment')->where('speech_language_impairment', '!=', '');
                } elseif ($sortByDisabilityType === 'Intellectual Disabilities') {
                    $query->whereNotNull('intellectual_disabilities')->where('intellectual_disabilities', '!=', '');
                } elseif ($sortByDisabilityType === 'Mobility Impairment') {
                    $query->whereNotNull('mobility_impairment')->where('mobility_impairment', '!=', '');
                } elseif ($sortByDisabilityType === 'Psycho-Social Disabilities') {
                    $query->whereNotNull('psycho_social_disabilities')->where('psycho_social_disabilities', '!=', '');
                } elseif ($sortByDisabilityType === 'Multiple Disabilities') {
                    $query->whereNotNull('multiple_disabilities')->where('multiple_disabilities', '!=', '');
                } elseif ($sortByDisabilityType === 'Other Disabilities') {
                    $query->whereNotNull('other_disabilities')->where('other_disabilities', '!=', '');
                }
            });
        }

        if ($sortByStatus) {
            $personQuery->whereHas('submittedForm', function ($query) use ($sortByStatus) {
                $query->where('status', '=', $sortByStatus)
                    ->orWhere('status', '=', $sortByStatus)
                    ->orWhere('status', '=', $sortByStatus);
            });
        }

        if ($sort === 'id') {
            $personQuery->orderByDesc('id');
        } else if ($sort === 'name') {
            $personQuery->orderByDesc('first_name');
        } else if ($sort === 'assisted') {
            $personQuery->leftJoin('submitted_forms', 'submitted_forms.person_with_disability_id', '=', 'person_with_disabilities.id')
                ->orderByDesc('assisted_by');
        } else if ($sort === 'status') {
            $personQuery->leftJoin('submitted_forms', 'submitted_forms.person_with_disability_id', '=', 'person_with_disabilities.id')
                ->orderByDesc('status');
        }

        $persons = $personQuery->simplePaginate(7);

        return view('fieldworker.dashboard', [
            'persons' => $persons,
            'sortedDisability' => $sortByDisabilityType,
            'sortedByStatus' => $sortByStatus,
            'sort' => $sort,
            'events' => $todaysEvent
        ]);
    }
    public function editPWDView(PersonWithDisability $personWithDisability)
    {
        $disabilityType = DisabilityType::where('person_with_disability_id', $personWithDisability->id)->first();

        $visualImpairment = explode(', ', $disabilityType->visual_impairment);
        $learningDisabilities = explode(', ', $disabilityType->learning_disabilities);
        $hearingImpairment = explode(', ', $disabilityType->hearing_impairment);
        $speechLanguageImpairment = explode(', ', $disabilityType->speech_language_impairment);
        $intellectualDisabilities = explode(', ', $disabilityType->intellectual_disabilities);
        $mobilityImpairment = explode(', ', $disabilityType->mobility_impairment);
        $psychoSocialDisabilities = explode(', ', $disabilityType->psycho_social_disabilities);
        $multipleDisabilities = explode(', ', $disabilityType->multiple_disabilities);
        $otherDisabilities = explode(', ', $disabilityType->other_disabilities);

        return view('fieldworker.edit-pwd', [
            'person' => $personWithDisability,
            'visualImpairment' => $visualImpairment,
            'learningDisabilities' => $learningDisabilities,
            'hearingImpairment' => $hearingImpairment,
            'speechLanguageImpairment' => $speechLanguageImpairment,
            'intellectualDisabilities' => $intellectualDisabilities,
            'mobilityImpairment' => $mobilityImpairment,
            'psychoSocialDisabilities' => $psychoSocialDisabilities,
            'multipleDisabilities' => $multipleDisabilities,
            'otherDisabilities' => $otherDisabilities
        ]);
    }
    public function storeUpdatedPWD(Request $request, PersonWithDisability $personWithDisability, EmploymentRecord $employmentRecord)
    {
        $storagePath = public_path('pwd-images');

        $request->validate([
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'middle_name' => ['required', 'string'],
            'present_house' => ['required', 'string'],
            'present_sitio' => ['required', 'string'],
            'present_baranggay' => ['required', 'string'],
            'present_city' => ['required', 'string'],
            'present_province' => ['required', 'string'],
            'province_house' => ['required', 'string'],
            'province_sitio' => ['required', 'string'],
            'province_baranggay' => ['required', 'string'],
            'province_city' => ['required', 'string'],
            'province_province' => ['required', 'string'],
            'sex' => ['required', 'string'],
            'civil_status' => ['required', 'string'],
            'date_of_birth' => ['required', 'string'],
            'place_of_birth' => ['required', 'string'],
            'contact_no' => ['required', 'string'],
            'email' => ['required', 'email'],
            'height' => ['required', 'string'],
            'weight' => ['required', 'string'],
            'religion' => ['required', 'string'],
            'elementary_school' => ['required', 'string'],
            'elementary_school_address' => ['required', 'string'],
            'high_school' => ['required', 'string'],
            'high_school_address' => ['required', 'string'],
            'vocational_school' => ['required', 'string'],
            'vocational_address' => ['required', 'string'],
            'college_school' => ['required', 'string'],
            'college_address' => ['required', 'string'],
            'duration' => ['nullable', 'array'],
            'company_name' => ['nullable', 'array'],
            'company_address' => ['nullable', 'array'],
            'visual_impairment' => ['nullable', 'array'],
            'speech_language_impairment' => ['nullable', 'array'],
            'learning_disabilities' => ['nullable', 'array'],
            'hearing_impairment' => ['nullable', 'array'],
            'intellectual_disabilities' => ['nullable', 'array'],
            'mobility_impairment' => ['nullable', 'array'],
            'psycho_social_disabilities' => ['nullable', 'array'],
            'multiple_disabilities' => ['nullable', 'array'],
            'other_disabilities' => ['nullable', 'array'],
            'profile' => ['nullable', 'mimes:jpg,jpeg,png'],
            'account_id' => ['required'],
            'resident_id' => ['required'],
            'baranggay_id' => ['required'],
            'date_submission' => ['required', 'date'],
            'submission_details' => ['required', 'string'],
            'assisted_by' => ['required', 'string'],
            'status' => ['required', 'string'],
            'guardian_full_name' => ['required'],
            'guardian_phone_number' => ['required'],
            'guardian_relationship' => ['required']
        ]);

        $personWithDisability->update($request->only([
            'last_name',
            'first_name',
            'middle_name',
            'present_house',
            'present_sitio',
            'present_baranggay',
            'present_city',
            'present_province',
            'province_house',
            'province_sitio',
            'province_baranggay',
            'province_city',
            'province_province',
            'sex',
            'civil_status',
            'date_of_birth',
            'place_of_birth',
            'contact_no',
            'email',
            'height',
            'weight',
            'religion'
        ]));

        $searchedEducationalAttainment = EducationalAttainment::findOrFail($personWithDisability->id);

        $searchedEducationalAttainment->update($request->only([
            'elementary_school',
            'elementary_school_address',
            'high_school',
            'high_school_address',
            'vocational_school',
            'vocational_address',
            'college_school',
            'college_address'
        ]));

        $durations = $request->input('duration', []);
        $companyNames = $request->input('company_name', []);
        $companyAddresses = $request->input('company_address', []);

        foreach ($personWithDisability->employmentRecord as $index => $employmentRecord) {
            if (isset($durations[$index])) {
                $employmentRecord->duration = $durations[$index];
                $employmentRecord->company_name = $companyNames[$index] ?? null;
                $employmentRecord->company_address = $companyAddresses[$index] ?? null;
                $employmentRecord->save();
            }
        }

        $visualImpairment = implode(', ', array_filter($request->input('visual_impairment', [])));
        $speechLanguageImpairment = implode(', ', array_filter($request->input('speech_language_impairment', [])));
        $learningDisabilities = implode(', ', array_filter($request->input('learning_disabilities', [])));
        $hearingImpairment = implode(', ', array_filter($request->input('hearing_impairment', [])));
        $intellectualDisabilities = implode(', ', array_filter($request->input('intellectual_disabilities', [])));
        $mobilityImpairment = implode(', ', array_filter($request->input('mobility_impairment', [])));
        $psychoSocialDisabilities = implode(', ', array_filter($request->input('psycho_social_disabilities', [])));
        $multipleDisabilities = implode(', ', array_filter($request->input('multiple_disabilities', [])));
        $otherDisabilities = implode(', ', array_filter($request->input('other_disabilities', [])));

        $searchedDisabilityType = DisabilityType::findOrFail($personWithDisability->id);

        $searchedDisabilityType->update([
            'visual_impairment' => $visualImpairment,
            'speech_language_impairment' => $speechLanguageImpairment,
            'learning_disabilities' => $learningDisabilities,
            'hearing_impairment' => $hearingImpairment,
            'intellectual_disabilities' => $intellectualDisabilities,
            'mobility_impairment' => $mobilityImpairment,
            'psycho_social_disabilities' => $psychoSocialDisabilities,
            'multiple_disabilities' => $multipleDisabilities,
            'other_disabilities' => $otherDisabilities,
        ]);

        if ($request->hasFile('profile')) {
            $profileFile = $request->file('profile');
            $fileName = time() . '_' . $profileFile->getClientOriginalName();
            $profileFile->move($storagePath, $fileName);
            $searchedDisabilityType->update(['profile' => $fileName]);
        }

        $searchedGuardian = Guardian::findOrFail($personWithDisability->id);
        $searchedGuardian->update($request->only([
            'guardian_full_name',
            'guardian_phone_number',
            'guardian_relationship',
        ]));

        $searchedSubmittedForm = SubmittedForm::findOrFail($personWithDisability->id);
        $searchedSubmittedForm->update($request->only([
            'account_id',
            'resident_id',
            'baranggay_id',
            'date_submission',
            'submission_details',
            'assisted_by',
            'status'
        ]));

        return redirect()->route('fieldworker-dashboard')->with('message', 'PWD Information updated successfully.');
    }
    public function deletePWD(PersonWithDisability $personWithDisability)
    {
        $foundPerson = PersonWithDisability::findOrFail($personWithDisability->id);
        $foundPerson->delete();
        return redirect()->back()->with('message', 'Person deleted successfully.');
    }
    public function createPWD()
    {
        $randomAccountId = rand(1000, 9999999);

        return view('fieldworker.add-pwd', [
            'generateId' => $randomAccountId
        ]);
    }
    public function storePWD(Request $request)
    {
        $pwdImagePath = public_path('pwd-images');
        $request->validate([
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'middle_name' => ['required', 'string'],
            'present_house' => ['required', 'string'],
            'present_sitio' => ['required', 'string'],
            'present_baranggay' => ['required', 'string'],
            'present_city' => ['required', 'string'],
            'present_province' => ['required', 'string'],
            'province_house' => ['required', 'string'],
            'province_sitio' => ['required', 'string'],
            'province_baranggay' => ['required', 'string'],
            'province_city' => ['required', 'string'],
            'province_province' => ['required', 'string'],
            'sex' => ['required', 'string'],
            'civil_status' => ['required', 'string'],
            'date_of_birth' => ['required', 'string'],
            'place_of_birth' => ['required', 'string'],
            'contact_no' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:person_with_disabilities'],
            'height' => ['required', 'string'],
            'weight' => ['required', 'string'],
            'religion' => ['required', 'string'],
            'elementary_school' => ['required', 'string'],
            'elementary_school_address' => ['required', 'string'],
            'high_school' => ['required', 'string'],
            'high_school_address' => ['required', 'string'],
            'vocational_school' => ['required', 'string'],
            'vocational_address' => ['required', 'string'],
            'college_school' => ['required', 'string'],
            'college_address' => ['required', 'string'],
            'duration' => ['nullable', 'array'],
            'company_name' => ['nullable', 'array'],
            'company_address' => ['nullable', 'array'],
            'visual_impairment' => ['nullable', 'array'],
            'speech_language_impairment' => ['nullable', 'array'],
            'learning_disabilities' => ['nullable', 'array'],
            'hearing_impairment' => ['nullable', 'array'],
            'intellectual_disabilities' => ['nullable', 'array'],
            'mobility_impairment' => ['nullable', 'array'],
            'psycho_social_disabilities' => ['nullable', 'array'],
            'multiple_disabilities' => ['nullable', 'array'],
            'other_disabilities' => ['nullable', 'array'],
            'profile' => ['required', 'mimes:jpg,jpeg,png'],
            'account_id' => ['required'],
            'resident_id' => ['required'],
            'baranggay_id' => ['required'],
            'date_submission' => ['required', 'date'],
            'submission_details' => ['required', 'string'],
            'assisted_by' => ['required', 'string'],
            'status' => ['required', 'string'],
            'guardian_full_name' => ['required'],
            'guardian_phone_number' => ['required'],
            'guardian_relationship' => ['required'],
        ]);

        $newPWD = new PersonWithDisability();
        $newPWD->last_name = $request->last_name;
        $newPWD->first_name = $request->first_name;
        $newPWD->middle_name = $request->middle_name;
        $newPWD->present_house = $request->present_house;
        $newPWD->present_sitio = $request->present_sitio;
        $newPWD->present_baranggay = $request->present_baranggay;
        $newPWD->present_city = $request->present_city;
        $newPWD->present_province = $request->present_province;
        $newPWD->province_house = $request->province_house;
        $newPWD->province_sitio = $request->province_sitio;
        $newPWD->province_baranggay = $request->province_baranggay;
        $newPWD->province_city = $request->province_city;
        $newPWD->province_province = $request->province_province;
        $newPWD->sex = $request->sex;
        $newPWD->civil_status = $request->civil_status;
        $newPWD->date_of_birth = $request->date_of_birth;
        $newPWD->place_of_birth = $request->place_of_birth;
        $newPWD->contact_no = $request->contact_no;
        $newPWD->email = $request->email;
        $newPWD->height = $request->height;
        $newPWD->weight = $request->weight;
        $newPWD->religion = $request->religion;
        $newPWD->save();

        EducationalAttainment::create([
            'person_with_disability_id' => $newPWD->id,
            'elementary_school' => $request->elementary_school,
            'elementary_school_address' => $request->elementary_school_address,
            'high_school' => $request->high_school,
            'high_school_address' => $request->high_school_address,
            'vocational_school' => $request->vocational_school,
            'vocational_address' => $request->vocational_address,
            'college_school' => $request->college_school,
            'college_address' => $request->college_address
        ]);

        $durations = $request->input('duration', []);
        $companyNames = $request->input('company_name', []);
        $companyAddresses = $request->input('company_address', []);

        foreach ($durations as $index => $duration) {
            EmploymentRecord::create([
                'person_with_disability_id' => $newPWD->id,
                'duration' => $duration,
                'company_name' => $companyNames[$index] ?? null,
                'company_address' => $companyAddresses[$index] ?? null
            ]);
        }

        $visualImpairment = implode(', ', array_filter($request->input('visual_impairment', [])));
        $speechLanguageImpairment = implode(', ', array_filter($request->input('speech_language_impairment', [])));
        $learningDisabilities = implode(', ', array_filter($request->input('learning_disabilities', [])));
        $hearingImpairment = implode(', ', array_filter($request->input('hearing_impairment', [])));
        $intellectualDisabilities = implode(', ', array_filter($request->input('intellectual_disabilities', [])));
        $mobilityImpairment = implode(', ', array_filter($request->input('mobility_impairment', [])));
        $psychoSocialDisabilities = implode(', ', array_filter($request->input('psycho_social_disabilities', [])));
        $multipleDisabilities = implode(', ', array_filter($request->input('multiple_disabilities', [])));
        $otherDisabilities = implode(', ', array_filter($request->input('other_disabilities', [])));

        $newDisabilitType = new DisabilityType();
        $newDisabilitType->person_with_disability_id = $newPWD->id;
        $newDisabilitType->visual_impairment = $visualImpairment;
        $newDisabilitType->speech_language_impairment = $speechLanguageImpairment;
        $newDisabilitType->learning_disabilities = $learningDisabilities;
        $newDisabilitType->hearing_impairment = $hearingImpairment;
        $newDisabilitType->intellectual_disabilities = $intellectualDisabilities;
        $newDisabilitType->mobility_impairment = $mobilityImpairment;
        $newDisabilitType->psycho_social_disabilities = $psychoSocialDisabilities;
        $newDisabilitType->multiple_disabilities = $multipleDisabilities;
        $newDisabilitType->other_disabilities = $otherDisabilities;

        if ($request->hasFile('profile')) {
            $profileFile = $request->file('profile');
            $fileName = time() . '_' . $profileFile->getClientOriginalName();

            $profileFile->move($pwdImagePath, $fileName);
            $newDisabilitType->profile = $fileName;
        }

        $newDisabilitType->save();

        Guardian::create([
            'person_with_disability_id' => $newPWD->id,
            'guardian_full_name' => $request->guardian_full_name,
            'guardian_phone_number' => $request->guardian_phone_number,
            'guardian_relationship' => $request->guardian_relationship,
        ]);

        BirthdayCashGift::create([
            'person_with_disability_id' => $newPWD->id
        ]);
        
        SubmittedForm::create([
            'person_with_disability_id' => $newPWD->id,
            'account_id' => $request->account_id,
            'resident_id' => $request->resident_id,
            'baranggay_id' => $request->baranggay_id,
            'date_submission' => $request->date_submission,
            'submission_details' => $request->submission_details,
            'assisted_by' => $request->assisted_by,
            'status' => $request->status
        ]);

        return redirect()->route('fieldworker-dashboard')->with('message', 'PWD Added successfully.');
    }
    public function eventsAndPrograms(Request $request)
    {
        $listOfEvents = Event::simplePaginate(5);

        $listOfEventQuery = Event::query();
        $currentDate = Carbon::now()->format('Y-m-d');
        $todaysEvent = Event::where('date', '=', $currentDate)->get();

        $searchEvent = $request->search_event;
        $sort = $request->sort;

        if ($searchEvent) {
            $listOfEventQuery->where(function ($query) use ($searchEvent) {
                $query->where('program_name', 'LIKE', '%' . $searchEvent . '%')
                    ->orWhere('location', 'LIKE', '%' . $searchEvent . '%');
            });
        }

        if ($sort === 'program_name') {
            $listOfEventQuery->orderByDesc('program_name');
        } else if ($sort === 'location') {
            $listOfEventQuery->orderByDesc('location');
        } else if ($sort === 'date') {
            $listOfEventQuery->orderByDesc('date');
        }

        $events = Event::all()->map(function ($event) {
            return [
                'title' => $event->program_name,
                'start' => $event->date
            ];
        });

        $listOfEvents = $listOfEventQuery->simplePaginate(5);

        return view('fieldworker.events-program.dashboard', [
            'events' => $events,
            'listOfEvents' => $listOfEvents,
            'sort' => $sort,
            'todayEvents' => $todaysEvent
        ]);
    }
    public function addEventView()
    {
        return view('fieldworker.events-program.create-event');
    }
    public function storeEvent(Request $request)
    {
        $storagePath = public_path('event-images');
        $request->validate([
            'program_name' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'nullable|string',
            'venue' => 'required|string',
            'duration' => 'required|numeric',
            'residency_requirements' => 'required|string',
            'visual_impairment' => 'nullable|array',
            'speech_language_impairment' => 'nullable|array',
            'learning_disabilities' => 'nullable|array',
            'hearing_impairment' => 'nullable|array',
            'intellectual_disabilities' => 'nullable|array',
            'mobility_impairment' => 'nullable|array',
            'psycho_social_disabilities' => 'nullable|array',
            'multiple_disabilities' => 'nullable|array',
            'other_disabilities' => 'nullable|array',
            'organizer_name' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'email' => 'nullable|string',
            'organizer_name_2' => 'nullable|string',
            'contact_number_2' => 'nullable|string',
            'email_2' => 'nullable|string',
            'organizer_name_3' => 'nullable|string',
            'contact_number_3' => 'nullable|string',
            'email_3' => 'nullable|string',
            'event_image' => 'required|mimes:jpeg,png,jpg'
        ]);

        $visualImpairment = implode(', ', array_filter($request->input('visual_impairment', [])));
        $speechLanguageImpairment = implode(', ', array_filter($request->input('speech_language_impairment', [])));
        $learningDisabilities = implode(', ', array_filter($request->input('learning_disabilities', [])));
        $hearingImpairment = implode(', ', array_filter($request->input('hearing_impairment', [])));
        $intellectualDisabilities = implode(', ', array_filter($request->input('intellectual_disabilities', [])));
        $mobilityImpairment = implode(', ', array_filter($request->input('mobility_impairment', [])));
        $psychoSocialDisabilities = implode(', ', array_filter($request->input('psycho_social_disabilities', [])));
        $multipleDisabilities = implode(', ', array_filter($request->input('multiple_disabilities', [])));
        $otherDisabilities = implode(', ', array_filter($request->input('other_disabilities', [])));

        $newEvent = new Event();

        $newEvent->program_name = $request->program_name;
        $newEvent->location = $request->location;
        $newEvent->date = $request->date;
        $newEvent->time = Carbon::parse($request->time)->format('H:i');
        $newEvent->venue = $request->venue;
        $newEvent->duration = $request->duration;
        $newEvent->description = $request->description;
        $newEvent->residency_requirements = $request->residency_requirements;

        $newEvent->visual_impairment = $visualImpairment;
        $newEvent->speech_language_impairment = $speechLanguageImpairment;
        $newEvent->learning_disabilities = $learningDisabilities;
        $newEvent->hearing_impairment = $hearingImpairment;
        $newEvent->intellectual_disabilities = $intellectualDisabilities;
        $newEvent->mobility_impairment = $mobilityImpairment;
        $newEvent->psycho_social_disabilities = $psychoSocialDisabilities;
        $newEvent->multiple_disabilities = $multipleDisabilities;
        $newEvent->other_disabilities = $otherDisabilities;

        $newEvent->organizer_name = $request->organizer_name;
        $newEvent->contact_number = $request->contact_number;
        $newEvent->email = $request->email;
        $newEvent->organizer_name_2 = $request->organizer_name_2;
        $newEvent->contact_number_2 = $request->contact_number_2;
        $newEvent->email_2 = $request->email_2;
        $newEvent->organizer_name_3 = $request->organizer_name_3;
        $newEvent->contact_number_3 = $request->contact_number_3;
        $newEvent->email_3 = $request->email_3;

        if ($request->has('event_image')) {

            $image = $request->file('event_image');
            $fileImage = time() . '_' . $image->getClientOriginalName();
            $image->move($storagePath, $fileImage);
            $newEvent->event_image = $fileImage;
        }

        $newEvent->save();

        return redirect('/fieldworker/events-programs')->with('message', 'Event added successfully!');
    }
    public function viewProgram(Event $event, Request $request)
    {
        $visualImpairment = explode(', ', $event->visual_impairment);
        $learningDisabilities = explode(', ', $event->learning_disabilities);
        $hearingImpairment = explode(', ', $event->hearing_impairment);
        $speechLanguageImpairment = explode(', ', $event->speech_language_impairment);
        $intellectualDisabilities = explode(', ', $event->intellectual_disabilities);
        $mobilityImpairment = explode(', ', $event->mobility_impairment);
        $psychoSocialDisabilities = explode(', ', $event->psycho_social_disabilities);
        $multipleDisabilities = explode(', ', $event->multiple_disabilities);
        $otherDisabilities = explode(', ', $event->other_disabilities);

        $sortBy = $request->get('sort', '');
        $searchQuery = $request->get('search_attending_person', '');

        $invitedPerson = DisabilityType::with(['personWithDisability.programAttendance' => function ($query) use ($event) {
            $query->where('event_id', $event->id);
        }])->where(function ($query) use (
            $visualImpairment,
            $learningDisabilities,
            $hearingImpairment,
            $speechLanguageImpairment,
            $intellectualDisabilities,
            $mobilityImpairment,
            $psychoSocialDisabilities,
            $multipleDisabilities,
            $otherDisabilities,
        ) {
            $query->whereIn('visual_impairment', $visualImpairment)
                ->orWhereIn('learning_disabilities', $learningDisabilities)
                ->orWhereIn('hearing_impairment', $hearingImpairment)
                ->orWhereIn('speech_language_impairment', $speechLanguageImpairment)
                ->orWhereIn('intellectual_disabilities', $intellectualDisabilities)
                ->orWhereIn('mobility_impairment', $mobilityImpairment)
                ->orWhereIn('psycho_social_disabilities', $psychoSocialDisabilities)
                ->orWhereIn('multiple_disabilities', $multipleDisabilities)
                ->orWhereIn('other_disabilities', $otherDisabilities);
        })->simplePaginate(5);

        $invitedPersonQuery = DisabilityType::with(['personWithDisability.programAttendance' => function ($query) use ($event) {
            $query->where('event_id', $event->id);
        }])
            ->where(function ($query) use (
                $visualImpairment,
                $learningDisabilities,
                $hearingImpairment,
                $speechLanguageImpairment,
                $intellectualDisabilities,
                $mobilityImpairment,
                $psychoSocialDisabilities,
                $multipleDisabilities,
                $otherDisabilities,
            ) {
                $query->whereIn('visual_impairment', $visualImpairment)
                    ->orWhereIn('learning_disabilities', $learningDisabilities)
                    ->orWhereIn('hearing_impairment', $hearingImpairment)
                    ->orWhereIn('speech_language_impairment', $speechLanguageImpairment)
                    ->orWhereIn('intellectual_disabilities', $intellectualDisabilities)
                    ->orWhereIn('mobility_impairment', $mobilityImpairment)
                    ->orWhereIn('psycho_social_disabilities', $psychoSocialDisabilities)
                    ->orWhereIn('multiple_disabilities', $multipleDisabilities)
                    ->orWhereIn('other_disabilities', $otherDisabilities);
            });

        if ($searchQuery) {
            $invitedPersonQuery->whereHas('personWithDisability', function ($subQuery) use ($searchQuery) {
                $subQuery->where('first_name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        if ($sortBy === 'id') {
            $invitedPersonQuery->join('person_with_disabilities', 'disability_types.id', '=', 'person_with_disabilities.id')
                ->orderByDesc('person_with_disabilities.id');
        } else if ($sortBy === 'name') {
            $invitedPersonQuery->join('person_with_disabilities', 'disability_types.id', '=', 'person_with_disabilities.id')
                ->orderByDesc('person_with_disabilities.first_name');
        } else if ($sortBy === 'baranggay') {
            $invitedPersonQuery->join('person_with_disabilities', 'disability_types.id', '=', 'person_with_disabilities.id')
                ->orderByDesc('person_with_disabilities.present_baranggay');
        }

        $invitedPerson = $invitedPersonQuery->select('disability_types.*')->simplePaginate(5);

        return view('fieldworker.events-program.view-program', [
            'program' => $event,
            'visualImpairment' => $visualImpairment,
            'learningDisabilities' => $learningDisabilities,
            'hearingImpairment' => $hearingImpairment,
            'speechLanguageImpairment' => $speechLanguageImpairment,
            'intellectualDisabilities' => $intellectualDisabilities,
            'mobilityImpairment' => $mobilityImpairment,
            'psychoSocialDisabilities' => $psychoSocialDisabilities,
            'multipleDisabilities' => $multipleDisabilities,
            'otherDisabilities' => $otherDisabilities,
            'invitedPerson' => $invitedPerson,
            'sort' => $sortBy
        ]);
    }
    public function editProgram(Event $event)
    {
        $visualImpairment = explode(', ', $event->visual_impairment);
        $learningDisabilities = explode(', ', $event->learning_disabilities);
        $hearingImpairment = explode(', ', $event->hearing_impairment);
        $speechLanguageImpairment = explode(', ', $event->speech_language_impairment);
        $intellectualDisabilities = explode(', ', $event->intellectual_disabilities);
        $mobilityImpairment = explode(', ', $event->mobility_impairment);
        $psychoSocialDisabilities = explode(', ', $event->psycho_social_disabilities);
        $multipleDisabilities = explode(', ', $event->multiple_disabilities);
        $otherDisabilities = explode(', ', $event->other_disabilities);

        $allDisabilities = array_merge(
            $visualImpairment,
            $learningDisabilities,
            $hearingImpairment,
            $speechLanguageImpairment,
            $intellectualDisabilities,
            $mobilityImpairment,
            $psychoSocialDisabilities,
        );

        $allDisabilities = array_filter($allDisabilities);

        return view('fieldworker.events-program.edit-event', [
            'event' => $event,
            'disabilities' => $allDisabilities,
            'multipleDisabilities' => array_filter($multipleDisabilities),
            'otherDisabilities' => array_filter($otherDisabilities)
        ]);
    }

    public function storeUpdatedEvent(Request $request, Event $event)
    {
        $storagePath = public_path('event-images');

        $request->validate([
            'program_name' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'nullable|string',
            'venue' => 'required|string',
            'duration' => 'required|numeric',
            'residency_requirements' => 'required|string',
            'visual_impairment' => 'nullable|array',
            'speech_language_impairment' => 'nullable|array',
            'learning_disabilities' => 'nullable|array',
            'hearing_impairment' => 'nullable|array',
            'intellectual_disabilities' => 'nullable|array',
            'mobility_impairment' => 'nullable|array',
            'psycho_social_disabilities' => 'nullable|array',
            'multiple_disabilities' => 'nullable|array',
            'other_disabilities' => 'nullable|array',
            'organizer_name' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'email' => 'nullable|string',
            'organizer_name_2' => 'nullable|string',
            'contact_number_2' => 'nullable|string',
            'email_2' => 'nullable|string',
            'organizer_name_3' => 'nullable|string',
            'contact_number_3' => 'nullable|string',
            'email_3' => 'nullable|string',
            'event_image' => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $eventsFound = Event::findOrFail($event->id);

        $visualImpairment = implode(', ', array_filter($request->input('visual_impairment', [])));
        $speechLanguageImpairment = implode(', ', array_filter($request->input('speech_language_impairment', [])));
        $learningDisabilities = implode(', ', array_filter($request->input('learning_disabilities', [])));
        $hearingImpairment = implode(', ', array_filter($request->input('hearing_impairment', [])));
        $intellectualDisabilities = implode(', ', array_filter($request->input('intellectual_disabilities', [])));
        $mobilityImpairment = implode(', ', array_filter($request->input('mobility_impairment', [])));
        $psychoSocialDisabilities = implode(', ', array_filter($request->input('psycho_social_disabilities', [])));
        $multipleDisabilities = implode(', ', array_filter($request->input('multiple_disabilities', [])));
        $otherDisabilities = implode(', ', array_filter($request->input('other_disabilities', [])));

        $eventsFound->update($request->only([
            'program_name',
            'location',
            'date',
            'time',
            'description',
            'venue',
            'duration',
            'residency_requirements',
            'organizer_name',
            'contact_number',
            'email',
            'organizer_name_2',
            'contact_number_2',
            'email_2',
            'organizer_name_3',
            'contact_number_3',
            'email_3',
        ]));

        $eventsFound->update([
            'visual_impairment' => $visualImpairment,
            'speech_language_impairment' => $speechLanguageImpairment,
            'learning_disabilities' => $learningDisabilities,
            'hearing_impairment' => $hearingImpairment,
            'intellectual_disabilities' => $intellectualDisabilities,
            'mobility_impairment' => $mobilityImpairment,
            'psycho_social_disabilities' => $psychoSocialDisabilities,
            'multiple_disabilities' => $multipleDisabilities,
            'other_disabilities' => $otherDisabilities,
        ]);

        if ($request->has('event_image')) {
            $image = $request->file('event_image');
            $fileImage = time() . '_' . $image->getClientOriginalName();
            $image->move($storagePath, $fileImage);

            $eventsFound->update(['event_image' => $fileImage]);
        }

        return redirect('/fieldworker/events-programs')->with('message', 'Program updated successfully.');
    }
    public function storeAttendance(Request $request)
    {
        $request->validate([
            'person_with_disability_id' => 'required|numeric',
            'event_id' => 'required|numeric',
            'program_name' => 'required|string',
            'baranggay' => 'required|string',
            'disabilities' => 'required|string',
            'attended' => 'required|string',
            'sex' => 'required|string'
        ]);

        ProgramAttendance::create([
            'person_with_disability_id' => $request->person_with_disability_id,
            'event_id' => $request->event_id,
            'program_name' => $request->program_name,
            'baranggay' => $request->baranggay,
            'attended' => $request->attended,
            'sex' => $request->sex,
            'disabilities' => $request->disabilities
        ]);

        return redirect()->back()->with('message', 'Attendance added successfully.');
    }
    public function programReportView(Event $event, ChartController $chart)
    {
        $personAttended = ProgramAttendance::with('personWithDisability')->where('event_id',  $event->id)->get();
        $disabilities = [];

        foreach ($personAttended as $attendance) {
            if ($attendance->personWithDisability) {
                $disabilities = array_merge($disabilities, explode(', ', $attendance->disabilities));
            }
        }

        $maleCount = $personAttended->filter(function ($attendance) {
            return $attendance->personWithDisability->sex === 'Male';
        })->count();

        $femaleCount = $personAttended->filter(function ($attendance) {
            return $attendance->personWithDisability->sex === 'Female';
        })->count();


        $attendedBaranggays = $personAttended->pluck('baranggay')->unique();

        $baranggayCounts = $personAttended->groupBy('baranggay')->map(function ($group, $key) {
            return [
                'barangay' => $key,
                'count' => $group->count()
            ];
        })->values();

        $barangayLabels = $baranggayCounts->pluck('barangay')->toArray();
        $attendedCounts = $baranggayCounts->pluck('count')->toArray();

        return view('fieldworker.events-program.program-report', [
            'personAttended' => $personAttended,
            'program' => $event,
            'sexChart' => $chart->programTotalGender($maleCount, $femaleCount),
            'disabilitiesChart' => $chart->programTotalDisabilities($disabilities),
            'baranggayChart' => $chart->programBaranggay($barangayLabels, $attendedCounts),
            'baranggay' => $attendedBaranggays,
            'baranggayCounts' => $baranggayCounts
        ]);
    }
    public function programInvitation(Request $request)
    {
        $disabilityType = explode(', ', $request->eventDisabilityType);
        $programId = $request->program_id;

        $event = Event::where('id', $programId)->first();

        return view('fieldworker.events-program.invitation', [
            'eventDisabilityType' => $disabilityType,
            'program' => $event
        ]);
    }
    public function sendProgramInvitation(Request $request)
    {
        session(['invitationData' => $request->all()]);

        return redirect('/fieldworker/events-programs/program/invitation/sent');
    }
    public function sendingInvitation()
    {
        $personInvited = session('invitationData');

        $sendTo = $personInvited['pwd_email'];
        $subject = 'Program Invitation: ' . $personInvited['program_name'];
        $message = 'Hello';

        Mail::to($sendTo)->send(new InvitationMail($message, $subject));

        return redirect('/fieldworker/events-programs')->with('message', 'Person invited successfully.');
    }
}
