<?php

namespace App\Http\Controllers;

use App\Models\Baranggay;
use App\Models\BaranggayAdmin;
use App\Models\DisabilityType;
use App\Models\EducationalAttainment;
use App\Models\EmploymentRecord;
use App\Models\Event;
use App\Models\FieldWorker;
use App\Models\Guardian;
use App\Models\PersonWithDisability;
use App\Models\SubmittedForm;
use App\Models\SuperAdmin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{

    public function dashboardView(ChartController $chart, Request $request)
    {
        $baranggays = Baranggay::simplePaginate(6);
        $pwd = PersonWithDisability::get();
        $disabilities = DisabilityType::get();
        $sort = $request->sort;
        $search = $request->search_baranggay;

        $currentDate = Carbon::now()->format('Y-m-d');
        $todaysEvent = Event::where('date', '=', $currentDate)->get();

        $baranggayQuery = Baranggay::query();

        if ($search) {
            $baranggayQuery->where('baranggay_name', 'LIKE', '%' . $search . '%');
        }

        if ($sort === 'Ascending') {
            $baranggayQuery->orderBy('baranggay_name', 'asc');
        } else if ($sort === 'Descending') {
            $baranggayQuery->orderBy('baranggay_name', 'desc');
        } else {
            $baranggayQuery->orderBy('baranggay_name', 'asc');
        }

        $grandMale = $pwd->filter(fn($person) => $person->sex === 'Male')->count();
        $grandFemale = $pwd->filter(fn($person) => $person->sex === 'Female')->count();

        $totalSingle = $pwd->filter(fn($person) => $person->civil_status === 'Single')->count();
        $totalMarried = $pwd->filter(fn($person) => $person->civil_status === 'Married')->count();
        $totalWidowed = $pwd->filter(fn($person) => $person->civil_status === 'Widowed')->count();

        $sophomore = $pwd->filter(fn($person) => Carbon::parse($person->date_of_birth)->age < 19)->count();
        $junior = $pwd->filter(fn($person) => Carbon::parse($person->date_of_birth)->age > 19 && Carbon::parse($person->date_of_birth)->age < 65)->count();
        $senior = $pwd->filter(fn($person) => Carbon::parse($person->date_of_birth)->age >= 65)->count();

        $active = $pwd->filter(fn($person) => $person->submittedForm->status === 'Active')->count();
        $moved = $pwd->filter(fn($person) => $person->submittedForm->status === 'Moved')->count();
        $deceased = $pwd->filter(fn($person) => $person->submittedForm->status === 'Deceased')->count();

        $disabilityCounts = [
            'Visual Impairment' => 0,
            'Speech Language Impairment' => 0,
            'Learning Disabilities' => 0,
            'Hearing Impairment' => 0,
            'Intellectual Disabilities' => 0,
            'Mobility Impairment' => 0,
            'Psycho-social Disabilities' => 0,
            'Multiple Disabilities' => 0,
            'Other Disabilities' => 0
        ];

        foreach ($disabilities as $disability) {
            if ($disability->visual_impairment) {
                $disabilityCounts['Visual Impairment']++;
            }
            if ($disability->speech_language_impairment) {
                $disabilityCounts['Speech Language Impairment']++;
            }
            if ($disability->learning_disabilities) {
                $disabilityCounts['Learning Disabilities']++;
            }
            if ($disability->hearing_impairment) {
                $disabilityCounts['Hearing Impairment']++;
            }
            if ($disability->intellectual_disabilities) {
                $disabilityCounts['Intellectual Disabilities']++;
            }
            if ($disability->mobility_impairment) {
                $disabilityCounts['Mobility Impairment']++;
            }
            if ($disability->psycho_social_disabilities) {
                $disabilityCounts['Psycho-social Disabilities']++;
            }
            if ($disability->multiple_disabilities) {
                $disabilityCounts['Multiple Disabilities']++;
            }
            if ($disability->other_disabilities) {
                $disabilityCounts['Other Disabilities']++;
            }
        }

        $baranggays = $baranggayQuery->simplePaginate(6);

        return view('super-admin.dashboard', [
            'baranggays' => $baranggays,
            'totalGenderChart' => $chart->overAllGender($grandMale, $grandFemale),
            'civilStatusChart' => $chart->civilStatus($totalSingle, $totalMarried, $totalWidowed),
            'ageChart' => $chart->ageGap($sophomore, $junior, $senior),
            'statusChart' => $chart->PWDStatus($active, $moved, $deceased),
            'pwdTypeChart' => $chart->disabilityType($disabilityCounts),
            'sort' => $sort,
            'events' => $todaysEvent
        ]);
    }
    public function createBaranggayView()
    {
        return view('super-admin.create-baranggay');
    }
    public function updateBaranggayView()
    {
        return view('super-admin.edit-baranggay');
    }

    public function storeBaranggay(Request $request)
    {
        $request->validate([
            'baranggay_name' => ['required', 'string'],
            'baranggay_capt_name' => ['required', 'string'],
            'baranggay_location' => ['required', 'string'],
            'baranggay_contact' => ['nullable', 'string'],
            'baranggay_desc' => ['nullable', 'string'],
        ]);

        $newBaranggay = new Baranggay();
        $newBaranggay->baranggay_name = $request->baranggay_name;
        $newBaranggay->baranggay_capt_name = $request->baranggay_capt_name;
        $newBaranggay->baranggay_location = $request->baranggay_location;
        $newBaranggay->baranggay_contact = $request->baranggay_contact;
        $newBaranggay->baranggay_desc = $request->baranggay_desc;

        $newBaranggay->save();
        return redirect()->route('dashboard')->with('message', 'Baranggay added successfully');
    }
    public function editBaranggayView(Baranggay $baranggay)
    {
        return view('super-admin.edit-baranggay', ['baranggay' => $baranggay]);
    }
    public function updatedBaranggay(Request $request, Baranggay $baranggay)
    {
        $request->validate([
            'baranggay_name' => ['required', 'string'],
            'baranggay_capt_name' => ['required', 'string'],
            'baranggay_location' => ['required', 'string'],
            'baranggay_contact' => ['nullable', 'string'],
            'baranggay_desc' => ['nullable', 'string'],
        ]);

        $baranggay->update([
            'baranggay_name' => $request->baranggay_name,
            'baranggay_capt_name' => $request->baranggay_capt_name,
            'baranggay_location' => $request->baranggay_location,
            'baranggay_contact' => $request->baranggay_contact,
            'baranggay_desc' => $request->baranggay_desc,
        ]);

        $baranggay->save();

        return redirect()->route('dashboard')->with('message', 'Baranggay updated successfully.');
    }

    public function deleteBaranggay(Baranggay $baranggay)
    {
        $foundBaranggay = Baranggay::findOrFail($baranggay->id);

        $foundBaranggay->delete();

        return redirect()->back()->with('message', 'Baranggay deleted successfully.');
    }

    public function accountDashboard(Request $request)
    {
        $accounts = User::simplePaginate(5);

        $accountQuery = User::with(['baranggay']);

        $searched = $request->search_person;
        $sort = $request->sort_by;

        $currentDate = Carbon::now()->format('Y-m-d');
        $todaysEvent = Event::where('date', '=', $currentDate)->get();

        if ($searched) {
            $accountQuery->where('full_name', 'LIKE', '%' . $request->search_person . '%');
        }

        if ($sort === 'Super Admin') {
            $accountQuery->where('account_type', 'Super Admin');
        } else if ($sort === 'Baranggay Admin') {
            $accountQuery->where('account_type', 'Baranggay Admin');
        } else if ($sort === 'Field Worker') {
            $accountQuery->where('account_type', 'Field Worker');
        }

        $accounts = $accountQuery->simplePaginate(5);

        return view('super-admin.account.dashboard', [
            'accounts' => $accounts,
            'sort' => $sort,
            'events' => $todaysEvent
        ]);
    }
    public function createAccountView()
    {
        $baranggay = Baranggay::get();
        return view('super-admin.account.create-account', ['baranggay' => $baranggay]);
    }
    public function storeAccount(Request $request)
    {
        /* dd($request->all()); */
        $request->validate([
            'baranggay_id' => ['required', 'numeric'],
            'account_type' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'contact_no' => ['required', 'string'],
            'contact_address' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'confirm_password' => ['required', 'string', 'same:password'],
        ]);

        $newAccount = new User();
        $newAccount->baranggay_id = $request->baranggay_id;
        $newAccount->account_type = $request->account_type;
        $newAccount->full_name = $request->full_name;
        $newAccount->email = $request->email;
        $newAccount->contact_no = $request->contact_no;
        $newAccount->contact_address = $request->contact_address;
        $newAccount->username = $request->username;
        $newAccount->password = Hash::make($request->password);
        $newAccount->save();

        return redirect()->route('account-dashboard')->with('message', 'Account added successfully.');
    }
    public function updateAccountView(User $user)
    {
        $baranggay = Baranggay::get();
        return view('super-admin.account.edit-account', [
            'user' => $user,
            'baranggay' => $baranggay
        ]);
    }
    public function storeUpdatedAccount(Request $request, User $user)
    {
        $request->validate([
            'account_type' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'contact_no' => ['required', 'string'],
            'contact_address' => ['required', 'string'],
            'username' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'confirm_password' => ['nullable', 'string', 'same:password'],
        ]);

        $user->update($request->only([
            'account_type',
            'full_name',
            'email',
            'contact_no',
            'contact_address',
            'username',
            'password' => Hash::make('password')
        ]));

        return redirect()->route('account-dashboard')->with('message', 'Account updated successfully.');
    }
    public function deleteAdministrator(User $user)
    {
        $administrator = User::findOrFail($user->id);
        $administrator->delete();

        return redirect()->back()->with('message', 'User deleted successfully.');
    }

    public function viewBaranggayReport(Baranggay $baranggay, ChartController $chart, Request $request)
    {
        $pwdPersons = PersonWithDisability::where('present_baranggay', $baranggay->baranggay_name)->simplePaginate(5);
        $person = PersonWithDisability::where('present_baranggay', $baranggay->baranggay_name)->get();
        $personQuery = PersonWithDisability::where('present_baranggay', $baranggay->baranggay_name);

        $female = $person->filter(fn($person) => $person->sex === 'Female')->count();
        $male = $person->filter(fn($person) => $person->sex === 'Male')->count();

        $sophomore = $person->filter(fn($person) => Carbon::parse($person->date_of_birth)->age < 19)->count();
        $junior = $person->filter(fn($person) => Carbon::parse($person->date_of_birth)->age > 19 && Carbon::parse($person->date_of_birth)->age < 65)->count();
        $senior = $person->filter(fn($person) => Carbon::parse($person->date_of_birth)->age >= 65)->count();

        $totalSingle = $person->filter(fn($person) => $person->civil_status === 'Single')->count();
        $totalMarried = $person->filter(fn($person) => $person->civil_status === 'Married')->count();
        $totalWidowed = $person->filter(fn($person) => $person->civil_status === 'Widowed')->count();

        $active = $person->filter(fn($person) => $person->submittedForm->status === 'Active')->count();
        $moved = $person->filter(fn($person) => $person->submittedForm->status === 'Moved')->count();
        $deceased = $person->filter(fn($person) => $person->submittedForm->status === 'Deceased')->count();

        $search = $request->search_person;
        $sort = $request->sort;
        $sortByDisabilityType = $request->sort_disability_type;
        $sortByStatus = $request->sort_status;

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

        if ($search) {
            $personQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('id', '=', $search);
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

        $pwdPersons = $personQuery->simplePaginate(5);

        return view('super-admin.report', [
            'baranggay' => $baranggay,
            'persons' => $pwdPersons,
            'sexChart' => $chart->overAllGender($male, $female),
            'ageChart' => $chart->ageGap($junior, $sophomore, $senior),
            'civilStatusChart' => $chart->civilStatus($totalSingle, $totalMarried, $totalWidowed),
            'pwdStatusChart' => $chart->PWDStatus($active, $moved, $deceased),
            'sort' => $sort,
            'sortedDisability' => $sortByDisabilityType,
            'sortedByStatus' => $sortByStatus
        ]);
    }

    public function addPWDView()
    {
        $randomAccountId = rand(1000, 9999999);

        return view('super-admin.add-pwd', [
            'generateId' => $randomAccountId
        ]);
    }
    public function storePWDInfo(Request $request)
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
            'guardian_relationship' => ['required']
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

        return redirect()->route('dashboard')->with('message', 'PWD Added successfully.');
    }
    public function deletePWD(PersonWithDisability $personWithDisability)
    {

        $foundedPerson = PersonWithDisability::findOrFail($personWithDisability->id);

        $foundedPerson->delete();

        return redirect()->back()->with('message', 'Person with disability deleted successfully.');
    }
    public function viewPWDInfo(PersonWithDisability $personWithDisability)
    {
        return view('super-admin.view-pwd', [
            'person' => $personWithDisability
        ]);
    }
    public function editPWDInfo(PersonWithDisability $personWithDisability)
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

        return view('super-admin.edit-pwd', [
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
    public function storeUpdatedPWDInfo(Request $request, PersonWithDisability $personWithDisability, EmploymentRecord $employmentRecord)
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

        return redirect()->route('dashboard')->with('message', 'PWD Information updated successfully.');
    }

    public function viewCensusData(Baranggay $baranggay, Request $request)
    {
        $persons = PersonWithDisability::where('present_baranggay', '=', $baranggay->baranggay_name)->simplePaginate(5);

        $personQuery = PersonWithDisability::where('present_baranggay', '=', $baranggay->baranggay_name);

        $search = $request->search_person;
        $sort = $request->sort;

        $search = $request->search_person;
        $sort = $request->sort;

        if ($search) {
            $personQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('id', '=', $search);
            });
        }

        if ($sort === 'id') {
            $personQuery->orderByDesc('id');
        } else if ($sort === 'name') {
            $personQuery->orderByDesc('first_name');
        } else if ($sort === 'status') {
            $personQuery->leftJoin('submitted_forms', 'submitted_forms.person_with_disability_id', '=', 'person_with_disabilities.id')
                ->orderByDesc('status');
        }

        $persons = $personQuery->simplePaginate(5);

        return view('super-admin.account.view-census', [
            'baranggay' => $baranggay,
            'persons' => $persons,
            'sort' => $sort
        ]);
    }
    public function changePasswordView(User $user)
    {

        return view('super-admin.account.change-password', ['user' => $user]);
    }
    public function changePassword(Request $request, User $user)
    {

        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
        ]);

        $user->update($request->only([
            'username',
        ]));

        $user->save();

        if ($request->has('password')) {

            $hashPassword = bcrypt($request->password);
            
            $user->update(['password' => $hashPassword]);
            $user->save();
        }

        return redirect()->route('dashboard')->with('message', 'Password changed successfully.');
    }
}
