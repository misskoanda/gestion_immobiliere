<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-amber-800 dark:text-amber-400 leading-tight">
            {{ __('Espace Propriétaire / Bailleur') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-2xl shadow-xl overflow-hidden text-white p-8 relative">
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold mb-2">Bienvenue, {{ Auth::user()->name }}</h3>
                    <p class="text-amber-100 max-w-xl">Publiez de nouvelles annonces de biens immobiliers et suivez leur état de validation par nos agents.</p>
                </div>
                <div class="absolute right-0 bottom-0 top-0 opacity-10 flex items-center justify-center pointer-events-none">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L2 12h3v8h14v-8h3L12 3zm0 5.5c1.38 0 2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5-2.5-1.12-2.5-2.5 1.12-2.5 2.5-2.5z"/></svg>
                </div>
            </div>

            <!-- Bailleur Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Stat 1: Total Properties -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Propriétés</p>
                    <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ Auth::user()->propertiesOwned()->count() }}</h4>
                </div>

                <!-- Stat 2: Published Properties -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Annonces Publiées</p>
                    <h4 class="text-3xl font-bold text-emerald-600 mt-1">{{ Auth::user()->propertiesOwned()->where('status', 'publiee')->count() }}</h4>
                </div>

                <!-- Stat 3: Pending Validation -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">En attente de validation</p>
                    <h4 class="text-3xl font-bold text-amber-500 mt-1">{{ Auth::user()->propertiesOwned()->where('status', 'en_attente')->count() }}</h4>
                </div>

                <!-- Stat 4: Refused / Retired -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Refusées ou Retirées</p>
                    <h4 class="text-3xl font-bold text-rose-500 mt-1">{{ Auth::user()->propertiesOwned()->whereIn('status', ['refusee', 'retiree'])->count() }}</h4>
                </div>
            </div>

            <!-- List of Deposited Properties -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-bold text-gray-800 dark:text-white">Mes Propriétés Déposées</h4>
                    <button class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl text-sm transition">
                        Ajouter un bien
                    </button>
                </div>

                @if(Auth::user()->propertiesOwned->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Vous n'avez pas encore déposé de biens immobiliers.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 font-semibold uppercase text-xs">
                                    <th class="py-3 px-4">Titre</th>
                                    <th class="py-3 px-4">Type</th>
                                    <th class="py-3 px-4">Usage / Option</th>
                                    <th class="py-3 px-4">Prix</th>
                                    <th class="py-3 px-4">Statut</th>
                                    <th class="py-3 px-4">Date de dépôt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Auth::user()->propertiesOwned()->latest()->get() as $property)
                                    <tr class="border-b border-gray-100 dark:border-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                        <td class="py-4 px-4 font-semibold text-gray-900 dark:text-white">{{ $property->title }}</td>
                                        <td class="py-4 px-4"><span class="capitalize">{{ $property->type }}</span></td>
                                        <td class="py-4 px-4">
                                            <span class="capitalize text-xs font-semibold px-2 py-0.5 bg-gray-100 dark:bg-gray-750 text-gray-600 dark:text-gray-400 rounded">{{ $property->usage }}</span>
                                            <span class="text-xs font-bold uppercase ml-1 {{ $property->option === 'vente' ? 'text-rose-600' : 'text-indigo-600' }}">{{ $property->option }}</span>
                                        </td>
                                        <td class="py-4 px-4 font-bold">{{ number_format($property->price, 2) }} DT</td>
                                        <td class="py-4 px-4">
                                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full 
                                                {{ $property->status === 'publiee' ? 'bg-emerald-100 text-emerald-800' : 
                                                   ($property->status === 'refusee' ? 'bg-rose-100 text-rose-800' : 
                                                   ($property->status === 'retiree' ? 'bg-gray-100 text-gray-800' : 'bg-amber-100 text-amber-800')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $property->status)) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-gray-400 dark:text-gray-500">{{ $property->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
