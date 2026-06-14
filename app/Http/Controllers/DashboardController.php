<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Redirect to the role-specific dashboard.
     */
    public function index(Request $request): RedirectResponse
    {
        $role = $request->user()->role;

        return match ($role) {
            'client' => redirect()->route('client.dashboard'),
            'bailleur' => redirect()->route('bailleur.dashboard'),
            'agent' => redirect()->route('agent.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            default => abort(403, 'Rôle non reconnu.'),
        };
    }

    /**
     * Client dashboard.
     */
    public function client(): View
    {
        return view('dashboard.client');
    }

    /**
     * Landlord (Bailleur) dashboard.
     */
    public function bailleur(): View
    {
        return view('dashboard.bailleur');
    }

    /**
     * Agent dashboard.
     */
    public function agent(): View
    {
        return view('dashboard.agent');
    }

    /**
     * Manager dashboard.
     */
    public function manager(): View
    {
        return view('dashboard.manager');
    }
}
