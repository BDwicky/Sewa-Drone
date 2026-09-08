<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function show(string $code): View
    {
        $booking = Booking::where('code', strtoupper($code))
            ->with(['drone', 'payments', 'invoice'])
            ->first();

        abort_unless($booking, 404);

        return view('track.show', ['booking' => $booking]);
    }
}
