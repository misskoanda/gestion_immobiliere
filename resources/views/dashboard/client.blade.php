<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-800 dark:text-indigo-400 leading-tight">
            {{ __('Tableau de Bord Client') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold mb-2">Ravi de vous revoir, {{ Auth::user()->name }} !</h3>
                    <p class="text-indigo-100 max-w-xl">Recherchez des propriétés, gérez vos favoris et suivez vos demandes de visite en temps réel.</p>
                </div>
                <div class="absolute right-0 bottom-0 top-0 opacity-10 flex items-center justify-center pointer-events-none">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                </div>
            </div>

            <!-- Client Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat 1: Favorites -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-pink-100 text-pink-600 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Mes Favoris</p>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ Auth::user()->favorites()->count() }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Stat 2: Visit Requests -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-indigo-100 text-indigo-600 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Demandes de visite</p>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ Auth::user()->visitRequests()->count() }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Assigned Agent -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition hover:shadow-md">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Mon Agent Dédié</p>
                            <h4 class="text-lg font-bold text-gray-800 dark:text-white">
                                {{ Auth::user()->clientAssignment ? Auth::user()->clientAssignment->agent->name : 'Non assigné' }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area: Favorites & Requests -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Visit Requests Section -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Mes Demandes de Visites Récentes</h4>
                    
                    @if(Auth::user()->visitRequests->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Vous n'avez pas encore envoyé de demandes de visite.</p>
                    @else
                        <div class="space-y-4">
                            @foreach(Auth::user()->visitRequests()->latest()->take(5)->get() as $request)
                                <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800">
                                    <div class="flex justify-between items-start mb-2">
                                        <h5 class="font-semibold text-gray-800 dark:text-white text-sm">{{ $request->property->title }}</h5>
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full 
                                            {{ $request->status === 'validee' ? 'bg-emerald-100 text-emerald-800' : ($request->status === 'refusee' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                        Date demandée : {{ $request->requested_date ? $request->requested_date->format('d/m/Y H:i') : 'Non spécifiée' }}
                                    </p>
                                    @if($request->agent_response)
                                        <div class="mt-2 text-xs p-2 bg-indigo-50 dark:bg-indigo-950 text-indigo-900 dark:text-indigo-200 rounded">
                                            <strong>Réponse de l'agent :</strong> {{ $request->agent_response }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Favorite Properties Section -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Mes Favoris Récents</h4>
                    
                    @if(Auth::user()->favoriteProperties->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Vous n'avez pas encore ajouté de propriétés à vos favoris.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach(Auth::user()->favoriteProperties()->latest()->take(4)->get() as $property)
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                                    <div class="p-4">
                                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">{{ $property->type }}</span>
                                        <h5 class="font-bold text-gray-800 dark:text-white text-sm mt-1 truncate">{{ $property->title }}</h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $property->location }}</p>
                                        <div class="mt-3 flex justify-between items-center">
                                            <span class="text-sm font-extrabold text-indigo-800 dark:text-indigo-400">{{ number_format($property->price, 2) }} DT</span>
                                            <span class="text-xs px-2 py-0.5 bg-gray-200 dark:bg-gray-700 rounded text-gray-700 dark:text-gray-300">{{ ucfirst($property->option) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
