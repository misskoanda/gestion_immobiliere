<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    /**
     * Display a listing of the published properties.
     */
    public function index(Request $request): View
    {
        $query = Property::where('status', 'publiee')->with(['mainPhoto', 'owner']);

        if ($request->has('type') && in_array($request->type, ['terrain', 'appartement', 'villa', 'batiment', 'commerce'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('option') && in_array($request->option, ['location', 'vente'])) {
            $query->where('option', $request->option);
        }

        $properties = $query->latest()->paginate(9);

        return view('front.properties.index', compact('properties'));
    }

    /**
     * Display the specified published property.
     */
    public function show(Property $property): View
    {
        if ($property->status !== 'publiee') {
            abort(404, 'Cette propriété n\'est pas disponible au public.');
        }

        $property->load(['photos', 'owner', 'agent']);

        return view('front.properties.show', compact('property'));
    }
}
