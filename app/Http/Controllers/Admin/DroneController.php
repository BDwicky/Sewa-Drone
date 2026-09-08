<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Drone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DroneController extends Controller
{
    public function index(): View
    {
        return view('admin.drones.index', [
            'drones' => Drone::withCount('bookings')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.drones.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('drones', 'public');
        }
        Drone::create($data);

        return redirect()->route('admin.drones.index')->with('status', 'Drone ditambahkan.');
    }

    public function edit(Drone $drone): View
    {
        return view('admin.drones.edit', ['drone' => $drone]);
    }

    public function update(Request $request, Drone $drone)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('drones', 'public');
        }
        $drone->update($data);

        return redirect()->route('admin.drones.index')->with('status', 'Drone diperbarui.');
    }

    public function destroy(Drone $drone)
    {
        if ($drone->bookings()->whereIn('status', Booking::ACTIVE_STATUSES)->exists()) {
            return back()->withErrors(['drone' => 'Tidak bisa dihapus: masih ada booking aktif. Nonaktifkan saja.']);
        }
        $drone->delete();

        return redirect()->route('admin.drones.index')->with('status', 'Drone dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'camera' => ['nullable', 'string', 'max:100'],
            'flight_time_min' => ['nullable', 'integer', 'min:0'],
            'range_km' => ['nullable', 'integer', 'min:0'],
            'weight_g' => ['nullable', 'integer', 'min:0'],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'weekly_rate' => ['nullable', 'numeric', 'min:0'],
            'pilot_daily_rate' => ['nullable', 'numeric', 'min:0'],
            'delivery_fee' => ['nullable', 'numeric', 'min:0'],
            'replacement_value' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:1', 'max:99'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ]);

        return $data;
    }
}
