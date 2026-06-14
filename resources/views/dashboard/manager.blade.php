<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-purple-855 dark:text-purple-400 leading-tight">
            {{ __('Administration Manager') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold mb-2">Console Administrateur : {{ Auth::user()->name }}</h3>
                    <p class="text-purple-100 max-w-xl">Supervisez l'activité globale du portail, affectez des clients aux agents et générez les rapports XML réglementaires.</p>
                </div>
                <div class="absolute right-0 bottom-0 top-0 opacity-10 flex items-center justify-center pointer-events-none">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/></svg>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Stat 1: Total Users -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Utilisateurs</p>
                    <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ \App\Models\User::count() }}</h4>
                </div>

                <!-- Stat 2: Total Properties -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Propriétés</p>
                    <h4 class="text-3xl font-bold text-indigo-650 mt-1">{{ \App\Models\Property::count() }}</h4>
                </div>

                <!-- Stat 3: Assignments -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Affectations Actives</p>
                    <h4 class="text-3xl font-bold text-purple-600 mt-1">{{ \App\Models\ClientAgentAssignment::count() }}</h4>
                </div>

                <!-- Stat 4: XML Exports -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Exports XML générés</p>
                    <h4 class="text-3xl font-bold text-pink-600 mt-1">{{ Auth::user()->xmlExports()->count() }}</h4>
                </div>
            </div>

            <!-- XML Exports & Assignments List -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- XML Exports List -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Historique des Exports XML</h4>
                        <button class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-xs font-semibold hover:bg-purple-700 transition">
                            Nouvel Export
                        </button>
                    </div>
                    
                    @if(Auth::user()->xmlExports->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Aucun export XML généré.</p>
                    @else
                        <div class="space-y-3">
                            @foreach(Auth::user()->xmlExports()->latest()->get() as $export)
                                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-xl flex justify-between items-center border border-gray-100 dark:border-gray-800">
                                    <div class="truncate mr-4">
                                        <p class="text-xs font-semibold text-gray-800 dark:text-white truncate">{{ basename($export->file_path) }}</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ $export->exported_at->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 font-semibold rounded">Prêt</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Active Client-Agent Assignments List -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Dernières affectations clients</h4>
                    
                    @if(Auth::user()->managedAssignments->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Aucune affectation effectuée.</p>
                    @else
                        <div class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach(Auth::user()->managedAssignments()->latest()->take(5)->get() as $assignment)
                                <div class="py-3 flex flex-col sm:flex-row justify-between sm:items-center text-sm">
                                    <div class="mb-1 sm:mb-0">
                                        <span class="font-semibold text-gray-800 dark:text-white">{{ $assignment->client->name }}</span>
                                        <span class="text-gray-400">assigné à</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $assignment->agent->name }}</span>
                                    </div>
                                    <span class="text-[11px] text-gray-400 dark:text-gray-500">{{ $assignment->assigned_at->format('d/m/Y') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
