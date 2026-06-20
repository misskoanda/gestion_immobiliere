<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the public home page with latest published properties.
     */
    public function index(): View
    {
        $properties = Property::where('status', 'publiee')
            ->with(['mainPhoto', 'owner'])
            ->latest()
            ->take(6)
            ->get();

        return view('front.home', compact('properties'));
    }
}
