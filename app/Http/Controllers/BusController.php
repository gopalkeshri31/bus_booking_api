<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        // Retrieve all available buses
        $buses = Bus::all();

        return response()->json(['buses' => $buses], 200);
    }

    public function show($id)
    {
        // Find a specific bus by its ID
        $bus = Bus::find($id);

        if (!$bus) {
            return response()->json(['message' => 'Bus not found'], 404);
        }

        return response()->json(['bus' => $bus], 200);
    }
}
