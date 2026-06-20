<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyPhoto;
use App\Models\ClientAgentAssignment;
use App\Models\VisitRequest;
use App\Models\XmlExport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // ─────────────────── ROUTING HUB ───────────────────

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

    // ─────────────────── CLIENT ───────────────────

    public function client(): View
    {
        return view('dashboard.client');
    }

    public function clientFavorites(): View
    {
        return view('dashboard.client.favorites');
    }

    public function clientVisitRequests(): View
    {
        return view('dashboard.client.visit_requests');
    }

    // ─────────────────── BAILLEUR ───────────────────

    public function bailleur(): View
    {
        return view('dashboard.bailleur');
    }

    public function bailleurProperties(): View
    {
        return view('dashboard.bailleur.properties');
    }

    public function bailleurPropertiesCreate(): View
    {
        return view('dashboard.bailleur.properties_create');
    }

    public function bailleurPropertiesStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:terrain,appartement,villa,batiment,commerce',
            'usage' => 'required|in:residence,bureau,commerce,agriculture',
            'option' => 'required|in:location,vente',
            'location' => 'required|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120',
        ]);

        $property = Auth::user()->propertiesOwned()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'usage' => $validated['usage'],
            'option' => $validated['option'],
            'location' => $validated['location'],
            'area' => $validated['area'] ?? null,
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'status' => 'en_attente',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('properties/' . $property->id, 'public');
                $property->photos()->create([
                    'path' => $path,
                    'is_main' => $index === 0,
                ]);
            }
        }

        return redirect()->route('bailleur.properties')->with('success', 'Annonce déposée avec succès. Elle sera examinée par un agent.');
    }

    public function bailleurPropertiesEdit(Property $property): View
    {
        abort_if($property->owner_id !== Auth::id(), 403);
        return view('dashboard.bailleur.properties_edit', compact('property'));
    }

    public function bailleurPropertiesUpdate(Request $request, Property $property): RedirectResponse
    {
        abort_if($property->owner_id !== Auth::id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:terrain,appartement,villa,batiment,commerce',
            'usage' => 'required|in:residence,bureau,commerce,agriculture',
            'option' => 'required|in:location,vente',
            'location' => 'required|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120',
        ]);

        $property->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('properties/' . $property->id, 'public');
                $property->photos()->create([
                    'path' => $path,
                    'is_main' => false,
                ]);
            }
        }

        return redirect()->route('bailleur.properties')->with('success', 'Annonce modifiée avec succès.');
    }

    public function bailleurPropertiesDestroy(Property $property): RedirectResponse
    {
        abort_if($property->owner_id !== Auth::id(), 403);
        $property->delete();
        return redirect()->route('bailleur.properties')->with('success', 'Annonce supprimée.');
    }

    // ─────────────────── AGENT ───────────────────

    public function agent(): View
    {
        return view('dashboard.agent');
    }

    public function agentPropertiesPending(): View
    {
        return view('dashboard.agent.properties_pending');
    }

    public function agentPropertiesApprove(Property $property): RedirectResponse
    {
        $property->update([
            'status' => 'publiee',
            'agent_id' => Auth::id(),
            'published_at' => now(),
        ]);
        return redirect()->route('agent.properties_pending')->with('success', 'Annonce validée et publiée.');
    }

    public function agentPropertiesReject(Property $property): RedirectResponse
    {
        $property->update([
            'status' => 'refusee',
            'agent_id' => Auth::id(),
        ]);
        return redirect()->route('agent.properties_pending')->with('success', 'Annonce refusée.');
    }

    public function agentVisitRequests(): View
    {
        return view('dashboard.agent.visit_requests');
    }

    public function agentVisitRequestApprove(VisitRequest $visitRequest): RedirectResponse
    {
        $visitRequest->update(['status' => 'validee']);
        return redirect()->route('agent.visit_requests')->with('success', 'Demande de visite validée.');
    }

    public function agentVisitRequestReject(VisitRequest $visitRequest): RedirectResponse
    {
        $visitRequest->update(['status' => 'refusee']);
        return redirect()->route('agent.visit_requests')->with('success', 'Demande de visite refusée.');
    }

    public function agentClients(): View
    {
        return view('dashboard.agent.clients');
    }

    // ─────────────────── MANAGER ───────────────────

    public function manager(): View
    {
        return view('dashboard.manager');
    }

    public function managerUsersActivate(User $user): RedirectResponse
    {
        $user->update(['is_active' => true]);
        return redirect()->back()->with('success', 'Utilisateur activé / validé.');
    }

    public function managerUsersDeactivate(User $user): RedirectResponse
    {
        $user->update(['is_active' => false]);
        return redirect()->back()->with('success', 'Utilisateur désactivé.');
    }

    // ─────────────────── MANAGER BACKOFFICE ───────────────────

    public function managerBackoffice(Request $request): View
    {
        $query = User::whereIn('role', ['agent', 'manager']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.manager.backoffice.index', compact('users'));
    }

    public function managerBackofficeCreate(): View
    {
        return view('dashboard.manager.backoffice.create');
    }

    public function managerBackofficeStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'role' => 'required|in:agent,manager',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => \Hash::make($validated['password']),
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('manager.backoffice')->with('success', 'Utilisateur backoffice créé avec succès.');
    }

    public function managerBackofficeEdit(User $user): View
    {
        abort_unless(in_array($user->role, ['agent', 'manager']), 404);
        return view('dashboard.manager.backoffice.edit', compact('user'));
    }

    public function managerBackofficeUpdate(Request $request, User $user): RedirectResponse
    {
        abort_unless(in_array($user->role, ['agent', 'manager']), 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'role' => 'required|in:agent,manager',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = \Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('manager.backoffice')->with('success', 'Utilisateur backoffice mis à jour avec succès.');
    }

    // ─────────────────── MANAGER CLIENTS ───────────────────

    public function managerClients(Request $request): View
    {
        $query = User::where('role', 'client');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.manager.clients.index', compact('users'));
    }

    public function managerClientsCreate(): View
    {
        return view('dashboard.manager.clients.create');
    }

    public function managerClientsStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'client',
            'password' => \Hash::make($validated['password']),
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('manager.clients')->with('success', 'Client créé avec succès.');
    }

    public function managerClientsEdit(User $user): View
    {
        abort_unless($user->role === 'client', 404);
        return view('dashboard.manager.clients.edit', compact('user'));
    }

    public function managerClientsUpdate(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'client', 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => $validated['is_active'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = \Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('manager.clients')->with('success', 'Client mis à jour avec succès.');
    }

    // ─────────────────── MANAGER BAILLEURS ───────────────────

    public function managerBailleurs(Request $request): View
    {
        $query = User::where('role', 'bailleur');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.manager.bailleurs.index', compact('users'));
    }

    public function managerBailleursCreate(): View
    {
        return view('dashboard.manager.bailleurs.create');
    }

    public function managerBailleursStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'bailleur',
            'password' => \Hash::make($validated['password']),
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('manager.bailleurs')->with('success', 'Bailleur créé avec succès.');
    }

    public function managerBailleursEdit(User $user): View
    {
        abort_unless($user->role === 'bailleur', 404);
        return view('dashboard.manager.bailleurs.edit', compact('user'));
    }

    public function managerBailleursUpdate(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'bailleur', 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'required|boolean',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => $validated['is_active'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = \Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('manager.bailleurs')->with('success', 'Bailleur mis à jour avec succès.');
    }

    public function managerAssignments(): View
    {
        return view('dashboard.manager.assignments');
    }

    public function managerAssignmentsStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:users,id',
            'agent_id' => 'required|exists:users,id',
        ]);

        // Remove existing assignment for this client if any
        ClientAgentAssignment::where('client_id', $validated['client_id'])->delete();

        ClientAgentAssignment::create([
            'client_id' => $validated['client_id'],
            'agent_id' => $validated['agent_id'],
            'manager_id' => Auth::id(),
            'assigned_at' => now(),
        ]);

        return redirect()->route('manager.assignments')->with('success', 'Affectation créée avec succès.');
    }

    public function managerAssignmentsDestroy(ClientAgentAssignment $assignment): RedirectResponse
    {
        $assignment->delete();
        return redirect()->route('manager.assignments')->with('success', 'Affectation supprimée.');
    }

    public function managerStatistics(): View
    {
        return view('dashboard.manager.statistics');
    }

    public function managerXmlExport(): View
    {
        return view('dashboard.manager.xml_export');
    }

    public function managerXmlExportGenerate(Request $request): RedirectResponse
    {
        $properties = Property::where('status', 'publiee')->with('owner')->get();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><properties></properties>');

        foreach ($properties as $p) {
            $node = $xml->addChild('property');
            $node->addChild('id', $p->id);
            $node->addChild('title', htmlspecialchars($p->title));
            $node->addChild('type', $p->type);
            $node->addChild('usage', $p->usage);
            $node->addChild('option', $p->option);
            $node->addChild('location', htmlspecialchars($p->location));
            $node->addChild('area', $p->area);
            $node->addChild('price', $p->price);
            $node->addChild('status', $p->status);
            $node->addChild('owner', htmlspecialchars($p->owner->name));
            $node->addChild('published_at', $p->published_at?->toISOString());
        }

        $filename = 'xml_exports/properties_' . now()->format('Y-m-d_His') . '.xml';
        Storage::disk('public')->put($filename, $xml->asXML());

        XmlExport::create([
            'manager_id' => Auth::id(),
            'file_path' => $filename,
            'exported_at' => now(),
        ]);

        return redirect()->route('manager.xml_export')->with('success', 'Export XML généré avec succès.');
    }

    // ─────────────────── MANAGER PROPERTIES ───────────────────

    public function managerProperties(Request $request): View
    {
        $query = Property::where('status', 'publiee')->with(['owner', 'agent']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest('published_at')->paginate(10)->withQueryString();

        return view('dashboard.manager.properties', compact('properties'));
    }

    public function managerPropertyWithdraw(Property $property): RedirectResponse
    {
        $property->update([
            'status' => 'retiree',
        ]);

        return redirect()->back()->with('success', 'L\'annonce a été retirée avec succès.');
    }
}
