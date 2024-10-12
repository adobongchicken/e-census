<?php

namespace App\Http\Controllers;

use App\Models\Baranggay;
use App\Models\BirthdayCashGift;
use App\Models\Event;
use App\Models\PersonWithDisability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BirthdayCashGiftsController extends Controller
{
    public function index(Request $request, ChartController $chart)
    {
        $birthdayEachMonth = array_fill(1, 12, 0);

        $currentDate = Carbon::now()->format('Y-m-d');

        $todaysEvent = Event::where('date', '=', $currentDate)->get();
        $barangay = Baranggay::get();

        $currentMonth = Carbon::now()->month;
        $birthMonth = PersonWithDisability::whereMonth('date_of_birth', $currentMonth)->get();

        $birthdayPersons = PersonWithDisability::get();

        $unreleased = $birthdayPersons->filter(function ($person) {
            return $person->birthdayCashGift && $person->birthdayCashGift->status === 'unreleased';
        })->count();

        $released = $birthdayPersons->filter(function ($person) {
            return $person->birthdayCashGift && $person->birthdayCashGift->status === 'released';
        })->count();

        $processing = $birthdayPersons->filter(function ($person) {
            return $person->birthdayCashGift && $person->birthdayCashGift->status === 'processing';
        })->count();

        $status = [$unreleased, $processing, $released];

        foreach ($birthdayPersons as $person) {
            $months = Carbon::parse($person->date_of_birth)->month;
            $birthdayEachMonth[$months]++;
        }

        return view('super-admin.event-program.birthday-cash-gift.dashboard', [
            'events' => $todaysEvent,
            'barangay' => $barangay,
            'birthdayChart' => $chart->birthdayMonthGraph($birthdayEachMonth),
            'statusChart' => $chart->cashGiftStatus($status),
            'birthdayNotification' => $birthMonth
        ]);
    }
    public function birthdayWithinBarangay(Baranggay $baranggay, ChartController $chart)
    {
        $birthdayEachMonth = array_fill(1, 12, 0);

        $birthdayPersons = PersonWithDisability::where('present_baranggay', '=', $baranggay->baranggay_name)->get();

        $currentMonth = Carbon::now()->month;
        $birthMonth = PersonWithDisability::whereMonth('date_of_birth', $currentMonth)->get();

        $unreleased = $birthdayPersons->filter(function ($person) {
            return $person->birthdayCashGift && $person->birthdayCashGift->status === 'unreleased';
        })->count();

        $released = $birthdayPersons->filter(function ($person) {
            return $person->birthdayCashGift && $person->birthdayCashGift->status === 'released';
        })->count();

        $processing = $birthdayPersons->filter(function ($person) {
            return $person->birthdayCashGift && $person->birthdayCashGift->status === 'processing';
        })->count();

        $status = [$unreleased, $processing, $released];

        foreach ($birthdayPersons as $person) {
            $months = Carbon::parse($person->date_of_birth)->month;
            $birthdayEachMonth[$months]++;
        }

        return view('super-admin.event-program.birthday-cash-gift.baranggay', [
            'barangay' => $baranggay,
            'birthdayChart' => $chart->birthdayMonthGraph($birthdayEachMonth),
            'statusChart' => $chart->cashGiftStatus($status),
            'persons' => $birthdayPersons,
            'birthdayNotification' => $birthMonth
        ]);
    }
    public function updateStatusForm(Baranggay $baranggay, PersonWithDisability $personWithDisability)
    {

        return view('super-admin.event-program.birthday-cash-gift.status-form', [
            'person' => $personWithDisability,
            'barangay' => $baranggay
        ]);
    }
    public function storeStatus(Request $request)
    {
        $storePath = public_path('proof');

        $request->validate([
            'person_id' => ['required'],
            'status' => ['nullable'],
            'proof' => ['nullable', 'mimes:jpeg,jpg,png']
        ]);

        $user = BirthdayCashGift::findOrFail($request->person_id);

        $user->update($request->only([
            'status'
        ]));

        if ($request->status === 'released') {
            $user->update([
                'release_date' => now()->format('Y-m-d H:i:s')
            ]);
        }

        if ($request->has('proof')) {
            $proof = $request->file('proof');

            $file = time() . '_' . $proof->getClientOriginalName();

            $proof->move($storePath, $file);

            $user->proof = $file;

            $user->save();
        }

        $user->save();

        return redirect()->route('cashGifts.super-admin')->with('message', 'Birthday Cash Gift status has been updated.');
    }
}
