<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    public function search(Request $request)
    {
        $query = Property::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', $request->bathrooms);
        }

        if ($request->filled('storeys')) {
            $query->where('storeys', $request->storeys);
        }

        if ($request->filled('garages')) {
            $query->where('garages', $request->garages);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $properties = $query->get();

        return response()->json([
            'success' => true,
            'count' => $properties->count(),
            'data' => $properties,
        ]);
    }
}
