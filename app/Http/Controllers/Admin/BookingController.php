<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $bookings = Booking::with(['drone', 'payments'])
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(20);

        $statusCounts = Booking::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $stats = [
            'total' => Booking::count(),
            'pending' => $statusCounts['pending'] ?? 0,
            'confirmed' => $statusCounts['confirmed'] ?? 0,
            'active' => $statusCounts['active'] ?? 0,
            'completed' => $statusCounts['completed'] ?? 0,
            'cancelled' => $statusCounts['cancelled'] ?? 0,
            'revenue' => (float) Booking::whereIn('status', ['confirmed', 'active', 'completed'])->sum('total_price'),
        ];

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'stats' => $stats,
        ]);
    }

    public function show(Booking $booking): View
    {
        $booking->load(['drone', 'payments', 'invoice']);

        return view('admin.bookings.show', ['booking' => $booking]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'active', 'completed', 'cancelled'])],
            'payment_note' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->update($validated);

        return back()->with('status', "Booking {$booking->code} → {$validated['status']}.");
    }
}
