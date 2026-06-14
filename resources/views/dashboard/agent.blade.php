<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-emerald-800 dark:text-emerald-400 leading-tight">
            {{ __('Portail Agent Immobilier') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold mb-2">Espace Agent : {{ Auth::user()->name }}</h3>
                    <p class="text-emerald-100 max-w-xl">Traitez les demandes de visites de vos clients assignés et gérez l'approbation des annonces de biens.</p>
                </div>
                <div class="absolute right-0 bottom-0 top-0 opacity-10 flex items-center justify-center pointer-events-none">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
            </div>

            <!-- Agent Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat 1: Assigned Clients -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Clients affectés</p>
                    <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ Auth::user()->agentAssignments()->count() }}</h4>
                </div>

                <!-- Stat 2: Assigned Visit Requests -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Demandes de visite assignées</p>
                    <h4 class="text-3xl font-bold text-indigo-650 mt-1">{{ Auth::user()->assignedVisitRequests()->count() }}</h4>
                </div>

                <!-- Stat 3: Managed Properties -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Biens sous gestion</p>
                    <h4 class="text-3xl font-bold text-teal-600 mt-1">{{ Auth::user()->propertiesManaged()->count() }}</h4>
                </div>
            </div>

            <!-- Two Column Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Visit Requests Handler -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Demandes de visites à traiter</h4>
                    
                    @if(Auth::user()->assignedVisitRequests->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Aucune demande de visite assignée pour le moment.</p>
                    @else
                        <div class="space-y-4">
                            @foreach(Auth::user()->assignedVisitRequests()->latest()->take(5)->get() as $request)
                                <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Client: {{ $request->client->name }}</span>
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full 
                                            {{ $request->status === 'validee' ? 'bg-emerald-100 text-emerald-800' : ($request->status === 'refusee' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                    <h5 class="font-bold text-gray-800 dark:text-white text-sm mb-1">{{ $request->property->title }}</h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Date demandée : {{ $request->requested_date ? $request->requested_date->format('d/m/Y H:i') : 'Non spécifiée' }}</p>
                                    @if($request->message)
                                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-950 p-2 rounded italic border border-gray-50 dark:border-gray-900">
                                            "{{ $request->message }}"
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Assigned Clients List -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Mes Clients Affectés</h4>
                    
                    @if(Auth::user()->agentAssignments->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Aucun client ne vous est actuellement affecté.</p>
                    @else
                        <div class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach(Auth::user()->agentAssignments()->latest()->get() as $assignment)
                                <div class="py-3 flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-white text-sm">{{ $assignment->client->name }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $assignment->client->email }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">Affecté le {{ $assignment->assigned_at->format('d/m/Y') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
