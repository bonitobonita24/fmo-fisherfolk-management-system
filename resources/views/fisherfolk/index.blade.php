<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Fisherfolk Records') }}
            </h2>
            @if(auth()->user()->hasPermission('fisherfolk', 'create'))
            <a href="{{ route('fisherfolk.create') }}" class="btn btn-primary btn-sm gap-2">
                <span class="icon-[tabler--plus] size-4"></span>
                Add Fisherfolk
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="alert alert-success mb-6">
                <span class="icon-[tabler--circle-check] size-5"></span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Search and Filter Section -->
            <div class="card bg-base-100 shadow-md mb-6">
                <div class="card-body">
                    <form method="GET" action="{{ route('fisherfolk.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="form-control">
                            <label for="search" class="label">
                                <span class="label-text">Search</span>
                            </label>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Name or ID..." 
                                   class="input input-bordered w-full">
                        </div>

                        <!-- Barangay Filter -->
                        <div class="form-control">
                            <label for="barangay" class="label">
                                <span class="label-text">Barangay</span>
                            </label>
                            <select name="barangay" id="barangay" class="select select-bordered w-full">
                                <option value="">All Barangays</option>
                                @foreach($barangays as $barangay)
                                <option value="{{ $barangay }}" {{ request('barangay') == $barangay ? 'selected' : '' }}>
                                    {{ $barangay }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sex Filter -->
                        <div class="form-control">
                            <label for="sex" class="label">
                                <span class="label-text">Gender</span>
                            </label>
                            <select name="sex" id="sex" class="select select-bordered w-full">
                                <option value="">All</option>
                                <option value="Male" {{ request('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-control justify-end">
                            <label class="label"><span class="label-text">&nbsp;</span></label>
                            <button type="submit" class="btn btn-primary w-full">
                                <span class="icon-[tabler--filter] size-4"></span>
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Fisherfolk Table -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Number</th>
                                    <th>Full Name</th>
                                    <th>Barangay</th>
                                    <th>Sex</th>
                                    <th>Age</th>
                                    <th>Categories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fisherfolk as $person)
                                <tr class="hover">
                                    <td class="font-medium">{{ $person->id_number }}</td>
                                    <td>{{ $person->full_name }}</td>
                                    <td>{{ $person->address }}</td>
                                    <td>
                                        <span class="badge {{ $person->sex == 'Male' ? 'badge-info' : 'badge-secondary' }}">
                                            {{ $person->sex }}
                                        </span>
                                    </td>
                                    <td>{{ $person->age }}</td>
                                    <td>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($person->categories as $category)
                                            <span class="badge badge-warning badge-soft badge-sm">
                                                {{ $category }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex gap-1">
                                            @if(auth()->user()->hasPermission('fisherfolk', 'view'))
                                            <a href="{{ route('fisherfolk.show', $person->id_number) }}" class="btn btn-ghost btn-xs btn-square" title="View">
                                                <span class="icon-[tabler--eye] size-4 text-primary"></span>
                                            </a>
                                            @endif
                                            
                                            @if(auth()->user()->hasPermission('fisherfolk', 'update'))
                                            <a href="{{ route('fisherfolk.edit', $person->id_number) }}" class="btn btn-ghost btn-xs btn-square" title="Edit">
                                                <span class="icon-[tabler--edit] size-4 text-info"></span>
                                            </a>
                                            @endif
                                            
                                            @if(auth()->user()->hasPermission('fisherfolk', 'delete'))
                                            <form method="POST" action="{{ route('fisherfolk.destroy', $person->id_number) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-xs btn-square" title="Delete">
                                                    <span class="icon-[tabler--trash] size-4 text-error"></span>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-base-content/60 py-8">
                                        No fisherfolk records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($fisherfolk->hasPages())
                    <div class="px-6 py-4 border-t border-base-300">
                        {{ $fisherfolk->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
