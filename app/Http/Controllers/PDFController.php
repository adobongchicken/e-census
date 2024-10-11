<?php

namespace App\Http\Controllers;

use App\Models\Baranggay;
use App\Models\DisabilityType;
use App\Models\Event;
use App\Models\PersonWithDisability;
use App\Models\ProgramAttendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function baranggayReport()
    {
        $pwd = PersonWithDisability::get();
        $disabilities = DisabilityType::get();

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

        $generatePDF = Pdf::loadView('report.baranggay-report', [
            'totalFemale' => $grandFemale,
            'totalMale' => $grandMale,
            'totalSingle' => $totalSingle,
            'totalMarried' => $totalMarried,
            'totalWidowed' => $totalWidowed,
            'totalSophomore' => $sophomore,
            'totalJunior' => $junior,
            'totalSenior' => $senior,
            'totalActive' => $active,
            'totalMoved' => $moved,
            'totalDeceased' => $deceased,
            'disabilities' => $disabilityCounts,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download('Barangay Report.pdf');
    }
    public function specificBaranggayReport(Baranggay $baranggay)
    {
        $person = PersonWithDisability::where('present_baranggay', $baranggay->baranggay_name)->get();
        $personDisability = PersonWithDisability::with('disabilityType')->leftJoin('disability_types', 'disability_types.id', '=', 'person_with_disabilities.id')->where('present_baranggay', '=', $baranggay->baranggay_name)->get();

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

        foreach ($personDisability as $disability) {
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

        $generatePDF = Pdf::loadView('report.specific-baranggay-report', [
            'female' => $female,
            'male' => $male,
            'sophomore' => $sophomore,
            'junior' => $junior,
            'senior' => $senior,
            'single' => $totalSingle,
            'married' => $totalMarried,
            'widowed' => $totalWidowed,
            'active' => $active,
            'moved' => $moved,
            'deceased' => $deceased,
            'baranggay' => $baranggay->baranggay_name,
            'disabilities' => $disabilityCounts,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download($baranggay->baranggay_name . ' Report.pdf');
    }
    public function personWithDisabilityData(PersonWithDisability $personWithDisability)
    {
        $generatePDF = Pdf::loadView('report.pwd-data', [
            'person' => $personWithDisability,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download($personWithDisability->first_name . ' ' . $personWithDisability->last_name . ' Data.pdf');
    }
    public function personWithinBaranggay(Baranggay $baranggay)
    {
        $pwdPersons = PersonWithDisability::where('present_baranggay', $baranggay->baranggay_name)->get();

        $generatePDF = Pdf::loadView('report.person-list', [
            'persons' => $pwdPersons,
            'baranggay' => $baranggay->baranggay_name,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download($baranggay->baranggay_name . ' List.pdf');
    }
    public function personWithinBaranggayWithDisability(Baranggay $baranggay)
    {
        $pwdPersons = PersonWithDisability::where('present_baranggay', $baranggay->baranggay_name)->get();

        $generatePDF = Pdf::loadView('report.person-list-with-disability', [
            'persons' => $pwdPersons,
            'baranggay' => $baranggay->baranggay_name,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download($baranggay->baranggay_name . ' List.pdf');
    }

    public function programEvent(Event $event)
    {
        $generatePDF = Pdf::loadView('report.program', [
            'event' => $event,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download($event->program_name . '.pdf');
    }
    public function programReport(Event $event)
    {
        $personAttended = ProgramAttendance::with('personWithDisability')->where('event_id',  $event->id)->get();

        $disabilities = [];

        foreach ($personAttended as $attendance) {
            if ($attendance->personWithDisability) {
                $disabilityList = explode(', ', $attendance->disabilities);
                foreach ($disabilityList as $disability) {
                    if (isset($disabilities[$disability])) {
                        $disabilities[$disability]++;
                    } else {
                        $disabilities[$disability] = 1;
                    }
                }
            }
        }

        $maleCount = $personAttended->filter(function ($attendance) {
            return $attendance->personWithDisability->sex === 'Male';
        })->count();

        $femaleCount = $personAttended->filter(function ($attendance) {
            return $attendance->personWithDisability->sex === 'Female';
        })->count();

        $baranggayCounts = $personAttended->groupBy('baranggay')->map(function ($group, $key) {
            return [
                'barangay' => $key,
                'count' => $group->count()
            ];
        })->values();

        $allBarangay = [];

        foreach ($baranggayCounts as $baranggayCount) {
            $allBarangay[$baranggayCount['barangay']] = $baranggayCount['count'];
        }

        $generatePDF = Pdf::loadView('report.program-report', [
            'event' => $event,
            'attendees' => $personAttended,
            'male' => $maleCount,
            'female' => $femaleCount,
            'baranggayAttended' => $allBarangay,
            'disabilities' => $disabilities,
            'logo' => public_path('assets/logo.png'),
            'pwd_logo' => public_path('assets/pwd-logo.jfif')
        ]);

        return $generatePDF->download($event->program_name . ' Report.pdf');
    }
}
