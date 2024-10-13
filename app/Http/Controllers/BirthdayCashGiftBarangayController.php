<?php

namespace App\Http\Controllers;

use App\Models\Baranggay;
use App\Models\BirthdayCashGift;
use App\Models\PersonWithDisability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BirthdayCashGiftBarangayController extends Controller
{
    public function index(Request $request, ChartController $chart)
    {
        $birthdayEachMonth = array_fill(1, 12, 0);

        $baranggay = Baranggay::where('baranggay_name', '=', auth()->user()->baranggay->baranggay_name)->first();

        $birthdayPersonsQuery = PersonWithDisability::with('birthdayCashGift')->where('present_baranggay', '=', $baranggay->baranggay_name);

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

        $sort = $request->sort;
        $search = $request->search_person;

        if ($search) {
            $birthdayPersonsQuery->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
        }

        if ($sort === 'processing') {
            $birthdayPersonsQuery->whereHas('birthdayCashGift', function ($query) {
                $query->where('status', '=', 'processing');
            });
        } else if ($sort === 'unreleased') {
            $birthdayPersonsQuery->whereHas('birthdayCashGift', function ($query) {
                $query->where('status', '=', 'unreleased');
            });
        } else if ($sort === 'released') {
            $birthdayPersonsQuery->whereHas('birthdayCashGift', function ($query) {
                $query->where('status', '=', 'released');
            });
        }

        $birthdayPersons = $birthdayPersonsQuery->get();

        return view('baranggay-admin.events-program.birthday-cash-gift.baranggay', [
            'barangay' => $baranggay,
            'birthdayChart' => $chart->birthdayMonthGraph($birthdayEachMonth),
            'statusChart' => $chart->cashGiftStatus($status),
            'persons' => $birthdayPersons,
            'birthdayNotification' => $birthMonth
        ]);
    }
    public function updateStatusForm(PersonWithDisability $personWithDisability)
    {
        return view('baranggay-admin.events-program.birthday-cash-gift.status-form', [
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

        return redirect('/baranggay-admin/events-programs/birthday-cash-gifts')->with('message', 'Birthday Cash Gift status has been updated.');
    }
}
