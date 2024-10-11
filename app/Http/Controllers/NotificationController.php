<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() {
        $currentDate = Carbon::now()->format('Y-m-d');
        $previousURL = url()->previous();

        $todaysEvent = Event::where('date', '=', $currentDate)->get();

        return view('components.notification', [
            'events' => $todaysEvent,
            'back' => $previousURL
        ]);
    }
}
