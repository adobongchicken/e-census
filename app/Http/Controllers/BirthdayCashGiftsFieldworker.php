<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baranggay;
use App\Models\BirthdayCashGift;
use App\Models\PersonWithDisability;
use Carbon\Carbon;

class BirthdayCashGiftsFieldworker extends Controller
{
    public function index(ChartController $chart)
    {
        $birthdayEachMonth = array_fill(1, 12, 0);

        $baranggay = Baranggay::where('baranggay_name', '=', auth()->user()->baranggay->baranggay_name)->first();

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

        return view('fieldworker.events-program.birthday-cash-gift.baranggay', [
            'barangay' => $baranggay,
            'birthdayChart' => $chart->birthdayMonthGraph($birthdayEachMonth),
            'statusChart' => $chart->cashGiftStatus($status),
            'persons' => $birthdayPersons,
            'birthdayNotification' => $birthMonth
        ]);
    }
    public function updateStatusForm(PersonWithDisability $personWithDisability)
    {
        return view('fieldworker.events-program.birthday-cash-gift.status-form', [
            'person' => $personWithDisability,
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

        return redirect('/fieldworker/events-programs/birthday-cash-gifts')->with('message', 'Birthday Cash Gift status has been updated.');
    }
}
