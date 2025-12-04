<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Fisherfolk Records') }}
            </h2>
            @if(auth()->user()->hasPermission('fisherfolk', 'create'))
            <a href="{{ route('fisherfolk.create') }}" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                Add Fisherfolk
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <form method="GET" action="{{ route('fisherfolk.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Name or ID..." 
                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    </div>

                    <!-- Barangay Filter -->
                    <div>
                        <label for="barangay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Barangay</label>
                        <select name="barangay" 
                                id="barangay" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">All Barangays</option>
                            @foreach($barangays as $barangay)
                            <option value="{{ $barangay }}" {{ request('barangay') == $barangay ? 'selected' : '' }}>
                                {{ $barangay }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sex Filter -->
                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                        <select name="sex" 
                                id="sex" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">All</option>
                            <option value="Male" {{ request('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Fisherfolk Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Barangay</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sex</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Age</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Categories</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($fisherfolk as $person)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $person->id_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $person->full_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $person->address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $person->sex == 'Male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $person->sex }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $person->age }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($person->categories as $category)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-secondary bg-opacity-20 text-sunset-orange">
                                            {{ $category }}
                                        </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if(auth()->user()->hasPermission('fisherfolk', 'view'))
                                        <a href="{{ route('fisherfolk.show', $person->id_number) }}" class="text-primary hover:text-blue-900">View</a>
                                        @endif
                                        
                                        @if(auth()->user()->hasPermission('fisherfolk', 'update'))
                                        <a href="{{ route('fisherfolk.edit', $person->id_number) }}" class="text-ocean-blue hover:text-blue-700">Edit</a>
                                        @endif
                                        
                                        @if(auth()->user()->hasPermission('fisherfolk', 'delete'))
                                        <form method="POST" action="{{ route('fisherfolk.destroy', $person->id_number) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No fisherfolk records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($fisherfolk->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                    {{ $fisherfolk->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
