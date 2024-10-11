<?php

namespace App\Http\Controllers;

use App\Mail\EventCancellationMail;
use App\Mail\InvitationMail;
use App\Models\DisabilityType;
use App\Models\Event;
use App\Models\PersonWithDisability;
use App\Models\ProgramAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

class EventController extends Controller
{
    public function index(Request $request)
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

        return view('super-admin.event-program.dashboard', [
            'events' => $events,
            'listOfEvents' => $listOfEvents,
            'sort' => $sort,
            'todayEvent' => $todaysEvent
        ]);
    }

    public function addEventView()
    {
        return view('super-admin.event-program.create-event');
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

        return redirect()->route('event-dashboard')->with('message', 'Event added successfully!');
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

        return view('super-admin.event-program.edit-event', [
            'event' => $event,
            'disabilities' => $allDisabilities,
            'multipleDisabilities' => array_filter($multipleDisabilities),
            'otherDisabilities' => array_filter($otherDisabilities)
        ]);
    }
    public function storeUpdatedProgram(Request $request, Event $event)
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
        return redirect()->route('event-dashboard')->with('message', 'Program updated successfully');
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

        return view('super-admin.event-program.view-program', [
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

        return view('super-admin.event-program.program-report', [
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

        return view('super-admin.event-program.invitation', [
            'eventDisabilityType' => $disabilityType,
            'program' => $event
        ]);
    }

    public function contactPersonView(PersonWithDisability $personWithDisability, Event $event)
    {
        return view('report.contact-form', ['person' => $personWithDisability, 'event' => $event]);
    }
    public function sendSMS(Request $request)
    {

        $request->validate(rules: [
            'program_name' => ['required', 'string'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'duration' => ['required', 'string'],
            'location' => ['required', 'string'],
            'venue' => ['required', 'string'],
            'pwd_phone_number' => ['required', 'numeric'],
            'guardian_phone_number' => ['required', 'numeric']

        ]);

        $configuration = new Configuration(
            host: 'nm86kj.api.infobip.com',
            apiKey: 'dd2bf76d84628fbe919e9c9e697c43cb-7e05193d-e0c7-4fa0-af16-badf3f456a29'
        );

        $sendSmsApi = new SmsApi(config: $configuration);

        
        $message = new SmsTextualMessage(
            destinations: [
                new SmsDestination(to: '+63' . $request->pwd_phone_number),
            ],

            from: 'Census',
            text: "Program Notice: {$request->program_name} is scheduled on {$request->date} at {$request->time} for {$request->duration} hours at {$request->location}, {$request->venue}."
        );

        $response = new SmsAdvancedTextualRequest(
            messages: [$message]
        );

        try {

            $response = $sendSmsApi->sendSmsMessage($response);

            return redirect()->route('event-dashboard')->with('message', 'SMS sent successfully!');

        } catch (\Exception $e) {
            // Handle any exceptions and return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send SMS: ' . $e->getMessage()
            ], 500);
        }
    }
    public function cancelledProgram(Request $request)
    {
        $validated = $request->validate([
            'event_id' => ['required', 'numeric'],
            'pwd_email' => ['required', 'array'],
            'cancellation_message' => ['required', 'string']
        ]);

        $event = Event::findOrFail($validated['event_id']);

        $subject = 'Program Cancellation Notice';
        $message = $validated['cancellation_message'];

        foreach ($validated['pwd_email'] as $email) {
            Mail::to($email)->send(new EventCancellationMail($subject, $message, $event));
        };

        $event->cancelled = true;
        $event->save();

        return redirect()->back()->with('message', 'The event has been successfully canceled.');
    }
    public function sendProgramInvitation(Request $request)
    {
        session(['invitationData' => $request->all()]);

        return redirect()->route('invitation-sent');
    }
    public function sendingInvitation()
    {
        $personInvited = session('invitationData');

        $sendTo = $personInvited['pwd_email'];
        $subject = 'Program Invitation: ' . $personInvited['program_name'];
        $message = 'Hello';

        Mail::to($sendTo)->send(new InvitationMail($message, $subject));

        return redirect()->route('event-dashboard')->with('message', 'Person invited successfully.');
    }
}
