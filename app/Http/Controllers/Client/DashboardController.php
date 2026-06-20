<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $favoritesCount = $user->favorites()->count();
        $visitRequestsCount = $user->visitRequests()->count();
        $recentVisitRequests = $user->visitRequests()->with(['property', 'agent'])->latest()->take(5)->get();
        $agent = $user->clientAssignment?->agent;

        return view('client.dashboard', compact('favoritesCount', 'visitRequestsCount', 'recentVisitRequests', 'agent'));
    }

    public function favorites(Request $request): View
    {
        $favorites = $request->user()->favoriteProperties()->with('mainPhoto')->latest()->paginate(12);
        return view('client.favorites', compact('favorites'));
    }

    public function visitRequests(Request $request): View
    {
        $visitRequests = $request->user()->visitRequests()->with(['property', 'agent'])->latest()->paginate(10);
        return view('client.visit_requests', compact('visitRequests'));
    }
}
