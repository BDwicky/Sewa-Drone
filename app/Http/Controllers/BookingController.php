<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Drone;
use App\Services\Notify;
use App\Services\Voucher;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request, Drone $drone): View
    {
        return view('bookings.create', [
            'drone' => $drone,
            'start_date' => $request->query('start_date'),
            'end_date' => $request->query('end_date'),
        ]);
    }

    public function store(StoreBookingRequest $request, Drone $drone)
    {
        $start = Carbon::parse($request->input('start_date'));
        $end = Carbon::parse($request->input('end_date'));
        $days = Booking::calcDays($start, $end);
        $withPilot = $request->boolean('with_pilot') && $drone->pilot_daily_rate;
        $delivery = $request->boolean('delivery') && $drone->delivery_fee;

        $total = Booking::calcPrice($drone, $days, $withPilot, $delivery);

        // Voucher (phase 4.5) — opsional
        $discount = 0.0;
        $voucherCode = strtoupper(trim((string) $request->input('voucher_code')));
        if ($voucherCode !== '') {
            $discount = Voucher::apply($voucherCode, $total);
            if ($discount > 0) {
                $total = max(0, $total - $discount);
            }
        }

        $booking = Booking::create([
            'code' => Booking::generateCode(),
            'drone_id' => $drone->id,
            'renter_name' => $request->input('renter_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'start_date' => $start,
            'end_date' => $end,
            'days' => $days,
            'total_price' => $total,
            'discount' => $discount,
            'with_pilot' => $withPilot,
            'delivery' => $delivery,
            'notes' => $request->input('notes'),
        ]);

        Notify::bookingCreated($booking);

        return redirect()->route('bookings.show', $booking->code);
    }

    public function show(string $code): View
    {
        $booking = Booking::where('code', $code)->with(['drone', 'payments', 'invoice'])->firstOrFail();

        return view('bookings.show', ['booking' => $booking]);
    }

    public function availability(Drone $drone): JsonResponse
    {
        return response()->json(
            $drone->bookings()
                ->whereIn('status', Booking::ACTIVE_STATUSES)
                ->get(['start_date', 'end_date'])
                ->map(fn ($b) => ['from' => $b->start_date->toDateString(), 'to' => $b->end_date->toDateString()])
                ->values()
        );
    }
}
