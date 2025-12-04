<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Fisherfolk Management Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Fisherfolk Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-primary hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Fisherfolk</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalFisherfolk) }}</p>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-full p-3">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Male Count Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-ocean-blue hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Male</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($maleCount) }}</p>
                        </div>
                        <div class="bg-ocean-blue bg-opacity-10 rounded-full p-3">
                            <svg class="w-8 h-8 text-ocean-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Female Count Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-secondary hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Female</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($femaleCount) }}</p>
                        </div>
                        <div class="bg-secondary bg-opacity-10 rounded-full p-3">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Barangays Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-sunset-orange hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Barangays</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $distinctBarangays }}</p>
                        </div>
                        <div class="bg-sunset-orange bg-opacity-10 rounded-full p-3">
                            <svg class="w-8 h-8 text-sunset-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Barangay Distribution Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div style="height: 400px;">
                        <canvas id="barangayChart"></canvas>
                    </div>
                </div>

                <!-- Gender Distribution Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div style="height: 400px;">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Additional Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Age Group Distribution Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div style="height: 400px;">
                        <canvas id="ageGroupChart"></canvas>
                    </div>
                </div>

                <!-- Activity Categories Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div style="height: 400px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Fisherfolk Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recently Registered Fisherfolk</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Barangay</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sex</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date Registered</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentFisherfolk as $person)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $person->id_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $person->full_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $person->address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $person->sex == 'Male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $person->sex }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $person->date_registered->format('M d, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No fisherfolk registered yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @vite('resources/js/charts.js')
    @endpush
</x-app-layout>
