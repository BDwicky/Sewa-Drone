<?php

namespace App\Http\Controllers;

use App\Models\Drone;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        return view('catalog.index', [
            'drones' => Drone::where('is_active', true)->orderBy('daily_rate')->get(),
        ]);
    }

    public function show(Drone $drone): View
    {
        abort_unless($drone->is_active, 404);

        return view('catalog.show', ['drone' => $drone]);
    }
}
