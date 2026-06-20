<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PropertyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─────────────────── FRONT-OFFICE (PUBLIC) ───────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/proprietes', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/proprietes/{property}', [PropertyController::class, 'show'])->name('properties.show');

// ─────────────────── DASHBOARD HUB ───────────────────

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// ─────────────────── CLIENT ROUTES ───────────────────

Route::middleware(['auth', 'role:client'])->prefix('client')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'client'])->name('client.dashboard');
    Route::get('/favoris', [DashboardController::class, 'clientFavorites'])->name('client.favorites');
    Route::get('/demandes-visite', [DashboardController::class, 'clientVisitRequests'])->name('client.visit_requests');
});

// ─────────────────── BAILLEUR ROUTES ───────────────────

Route::middleware(['auth', 'role:bailleur'])->prefix('bailleur')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'bailleur'])->name('bailleur.dashboard');
    Route::get('/proprietes', [DashboardController::class, 'bailleurProperties'])->name('bailleur.properties');
    Route::get('/proprietes/ajouter', [DashboardController::class, 'bailleurPropertiesCreate'])->name('bailleur.properties.create');
    Route::post('/proprietes', [DashboardController::class, 'bailleurPropertiesStore'])->name('bailleur.properties.store');
    Route::get('/proprietes/{property}/modifier', [DashboardController::class, 'bailleurPropertiesEdit'])->name('bailleur.properties.edit');
    Route::put('/proprietes/{property}', [DashboardController::class, 'bailleurPropertiesUpdate'])->name('bailleur.properties.update');
    Route::delete('/proprietes/{property}', [DashboardController::class, 'bailleurPropertiesDestroy'])->name('bailleur.properties.destroy');
});

// ─────────────────── AGENT ROUTES ───────────────────

Route::middleware(['auth', 'role:agent'])->prefix('agent')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');
    Route::get('/annonces-en-attente', [DashboardController::class, 'agentPropertiesPending'])->name('agent.properties_pending');
    Route::post('/annonces/{property}/valider', [DashboardController::class, 'agentPropertiesApprove'])->name('agent.properties.approve');
    Route::post('/annonces/{property}/refuser', [DashboardController::class, 'agentPropertiesReject'])->name('agent.properties.reject');
    Route::get('/demandes-visite', [DashboardController::class, 'agentVisitRequests'])->name('agent.visit_requests');
    Route::post('/demandes-visite/{visitRequest}/valider', [DashboardController::class, 'agentVisitRequestApprove'])->name('agent.visit_requests.approve');
    Route::post('/demandes-visite/{visitRequest}/refuser', [DashboardController::class, 'agentVisitRequestReject'])->name('agent.visit_requests.reject');
    Route::get('/clients', [DashboardController::class, 'agentClients'])->name('agent.clients');
});

// ─────────────────── MANAGER ROUTES ───────────────────

Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'manager'])->name('manager.dashboard');
    // Backoffice management
    Route::get('/backoffice', [DashboardController::class, 'managerBackoffice'])->name('manager.backoffice');
    Route::get('/backoffice/creer', [DashboardController::class, 'managerBackofficeCreate'])->name('manager.backoffice.create');
    Route::post('/backoffice', [DashboardController::class, 'managerBackofficeStore'])->name('manager.backoffice.store');
    Route::get('/backoffice/{user}/modifier', [DashboardController::class, 'managerBackofficeEdit'])->name('manager.backoffice.edit');
    Route::put('/backoffice/{user}', [DashboardController::class, 'managerBackofficeUpdate'])->name('manager.backoffice.update');

    // Clients management
    Route::get('/clients', [DashboardController::class, 'managerClients'])->name('manager.clients');
    Route::get('/clients/creer', [DashboardController::class, 'managerClientsCreate'])->name('manager.clients.create');
    Route::post('/clients', [DashboardController::class, 'managerClientsStore'])->name('manager.clients.store');
    Route::get('/clients/{user}/modifier', [DashboardController::class, 'managerClientsEdit'])->name('manager.clients.edit');
    Route::put('/clients/{user}', [DashboardController::class, 'managerClientsUpdate'])->name('manager.clients.update');

    // Bailleurs management
    Route::get('/bailleurs', [DashboardController::class, 'managerBailleurs'])->name('manager.bailleurs');
    Route::get('/bailleurs/creer', [DashboardController::class, 'managerBailleursCreate'])->name('manager.bailleurs.create');
    Route::post('/bailleurs', [DashboardController::class, 'managerBailleursStore'])->name('manager.bailleurs.store');
    Route::get('/bailleurs/{user}/modifier', [DashboardController::class, 'managerBailleursEdit'])->name('manager.bailleurs.edit');
    Route::put('/bailleurs/{user}', [DashboardController::class, 'managerBailleursUpdate'])->name('manager.bailleurs.update');
    Route::patch('/utilisateurs/{user}/activer', [DashboardController::class, 'managerUsersActivate'])->name('manager.users.activate');
    Route::patch('/utilisateurs/{user}/desactiver', [DashboardController::class, 'managerUsersDeactivate'])->name('manager.users.deactivate');
    Route::get('/affectations', [DashboardController::class, 'managerAssignments'])->name('manager.assignments');
    Route::post('/affectations', [DashboardController::class, 'managerAssignmentsStore'])->name('manager.assignments.store');
    Route::delete('/affectations/{assignment}', [DashboardController::class, 'managerAssignmentsDestroy'])->name('manager.assignments.destroy');
    Route::get('/statistiques', [DashboardController::class, 'managerStatistics'])->name('manager.statistics');
    Route::get('/export-xml', [DashboardController::class, 'managerXmlExport'])->name('manager.xml_export');
    Route::post('/export-xml/generer', [DashboardController::class, 'managerXmlExportGenerate'])->name('manager.xml_export.generate');

    // Properties management
    Route::get('/proprietes', [DashboardController::class, 'managerProperties'])->name('manager.properties');
    Route::post('/proprietes/{property}/retirer', [DashboardController::class, 'managerPropertyWithdraw'])->name('manager.properties.withdraw');
});

// ─────────────────── PROFILE ───────────────────

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
