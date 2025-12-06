<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="icon-[tabler--layout-dashboard] size-5 text-primary"></span>
            <h2 class="font-semibold text-xl text-base-content">Dashboard</h2>
        </div>
    </x-slot>

    <div class="p-4 lg:p-6">
        {{-- Statistics Block Formation - Using flex for proper alignment --}}
        <div class="flex flex-col lg:flex-row gap-4 mb-6">
            {{-- Total Registered Block - 25% width on desktop, contains sub-blocks --}}
            <div class="w-full lg:w-1/4 card bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20 shadow-sm">
                <div class="card-body p-2">
                    {{-- Year indicator --}}
                    <div class="text-center mb-1">
                        <span class="badge badge-primary badge-xs">{{ $currentYear }}</span>
                    </div>
                    
                    {{-- Row 1: Total Registered (left) + New Registration & Renewal stacked (right) --}}
                    <div class="flex gap-0 items-center mb-1">
                        {{-- Left: Total Registered Fisherfolk - takes full height --}}
                        <div class="bg-base-100/50 rounded-lg p-2 text-center flex-1 flex flex-col justify-center" style="border-right: 1px solid rgba(255,255,255,0.2);">
                            <div class="bg-primary/20 rounded-lg p-1 inline-flex mb-1 mx-auto">
                                <span class="icon-[tabler--users-group] size-4 text-primary"></span>
                            </div>
                            <p class="text-[8px] text-base-content/60 uppercase tracking-wide leading-tight mb-0">Total Registered</p>
                            <h3 class="font-bold text-base-content" style="font-size: 4rem; line-height: 1;">{{ number_format($registrationStats['total']['count']) }}</h3>
                            @if($registrationStats['total']['change']['direction'] === 'up')
                                <span class="text-[8px] text-success">+{{ $registrationStats['total']['change']['value'] }}%</span>
                            @elseif($registrationStats['total']['change']['direction'] === 'down')
                                <span class="text-[8px] text-error">-{{ $registrationStats['total']['change']['value'] }}%</span>
                            @else
                                <span class="text-[8px] text-base-content/40">0%</span>
                            @endif
                        </div>

                        {{-- Right: New Registration & Renewal stacked --}}
                        <div class="flex flex-col gap-1 flex-1">
                            {{-- New Registration --}}
                            <div class="bg-base-100/50 rounded-lg p-1.5 text-center flex-1">
                                <div class="flex items-center justify-center gap-1.5">
                                    <div class="bg-success/20 rounded-lg p-1">
                                        <span class="icon-[tabler--user-plus] size-3 text-success"></span>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-[8px] text-base-content/60 uppercase leading-tight">New</p>
                                        <h3 class="text-base font-bold text-base-content leading-none">{{ number_format($registrationStats['new']['count']) }}</h3>
                                    </div>
                                </div>
                            </div>

                            {{-- Renewal --}}
                            <div class="bg-base-100/50 rounded-lg p-1.5 text-center flex-1">
                                <div class="flex items-center justify-center gap-1.5">
                                    <div class="bg-info/20 rounded-lg p-1">
                                        <span class="icon-[tabler--refresh] size-3 text-info"></span>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-[8px] text-base-content/60 uppercase leading-tight">Renewal</p>
                                        <h3 class="text-base font-bold text-base-content leading-none">{{ number_format($registrationStats['renewed']['count']) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Divider line --}}
                    <div class="border-t border-base-content/10"></div>

                    {{-- Row 2: Inactive - spans full width --}}
                    <div class="bg-base-100/50 rounded-lg p-1.5 text-center mt-1">
                        <div class="flex items-center justify-center gap-2">
                            <div class="bg-warning/20 rounded-lg p-1">
                                <span class="icon-[tabler--user-off] size-3 text-warning"></span>
                            </div>
                            <div class="text-left">
                                <p class="text-[8px] text-base-content/60 uppercase leading-tight">Inactive</p>
                                <h3 class="text-base font-bold text-base-content leading-none">{{ number_format($registrationStats['inactive']['count']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Categories Grid - 75% width on desktop, 2 rows x 3 cols --}}
            <div class="w-full lg:w-3/4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 content-start">
                {{-- Row 1: Capture Fishing, Fish Vending, Boat Owner/Operator --}}
                {{-- Capture Fishing --}}
                <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-info/10 rounded-lg p-2 shrink-0">
                                <span class="icon-[tabler--fish] size-5 text-info"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-base-content/60">Capture Fishing</p>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-base-content">{{ number_format($activityStats['capture_fishing']['count']) }}</h3>
                                    @if($activityStats['capture_fishing']['change']['direction'] === 'up')
                                        <span class="text-xs text-success font-medium">+{{ $activityStats['capture_fishing']['change']['value'] }}%</span>
                                    @elseif($activityStats['capture_fishing']['change']['direction'] === 'down')
                                        <span class="text-xs text-error font-medium">-{{ $activityStats['capture_fishing']['change']['value'] }}%</span>
                                    @else
                                        <span class="text-xs text-base-content/40">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Fish Vending --}}
                <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-error/10 rounded-lg p-2 shrink-0">
                                <span class="icon-[tabler--shopping-cart] size-5 text-error"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-base-content/60">Fish Vending</p>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-base-content">{{ number_format($activityStats['vendor']['count']) }}</h3>
                                    @if($activityStats['vendor']['change']['direction'] === 'up')
                                        <span class="text-xs text-success font-medium">+{{ $activityStats['vendor']['change']['value'] }}%</span>
                                    @elseif($activityStats['vendor']['change']['direction'] === 'down')
                                        <span class="text-xs text-error font-medium">-{{ $activityStats['vendor']['change']['value'] }}%</span>
                                    @else
                                        <span class="text-xs text-base-content/40">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Boat Owner/Operator --}}
                <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary/10 rounded-lg p-2 shrink-0">
                                <span class="icon-[tabler--sailboat] size-5 text-primary"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-base-content/60">Boat Owner/Operator</p>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-base-content">{{ number_format($activityStats['boat_owner']['count']) }}</h3>
                                    @if($activityStats['boat_owner']['change']['direction'] === 'up')
                                        <span class="text-xs text-success font-medium">+{{ $activityStats['boat_owner']['change']['value'] }}%</span>
                                    @elseif($activityStats['boat_owner']['change']['direction'] === 'down')
                                        <span class="text-xs text-error font-medium">-{{ $activityStats['boat_owner']['change']['value'] }}%</span>
                                    @else
                                        <span class="text-xs text-base-content/40">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Gleaning, Aquaculture, Fish Processing --}}
                {{-- Gleaning --}}
                <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-success/10 rounded-lg p-2 shrink-0">
                                <span class="icon-[tabler--basket] size-5 text-success"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-base-content/60">Gleaning</p>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-base-content">{{ number_format($activityStats['gleaning']['count']) }}</h3>
                                    @if($activityStats['gleaning']['change']['direction'] === 'up')
                                        <span class="text-xs text-success font-medium">+{{ $activityStats['gleaning']['change']['value'] }}%</span>
                                    @elseif($activityStats['gleaning']['change']['direction'] === 'down')
                                        <span class="text-xs text-error font-medium">-{{ $activityStats['gleaning']['change']['value'] }}%</span>
                                    @else
                                        <span class="text-xs text-base-content/40">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Aquaculture --}}
                <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-secondary/10 rounded-lg p-2 shrink-0">
                                <span class="icon-[tabler--ripple] size-5 text-secondary"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-base-content/60">Aquaculture</p>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-base-content">{{ number_format($activityStats['aquaculture']['count']) }}</h3>
                                    @if($activityStats['aquaculture']['change']['direction'] === 'up')
                                        <span class="text-xs text-success font-medium">+{{ $activityStats['aquaculture']['change']['value'] }}%</span>
                                    @elseif($activityStats['aquaculture']['change']['direction'] === 'down')
                                        <span class="text-xs text-error font-medium">-{{ $activityStats['aquaculture']['change']['value'] }}%</span>
                                    @else
                                        <span class="text-xs text-base-content/40">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Fish Processing --}}
                <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body p-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-warning/10 rounded-lg p-2 shrink-0">
                                <span class="icon-[tabler--tools-kitchen-2] size-5 text-warning"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-base-content/60">Fish Processing</p>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-base-content">{{ number_format($activityStats['fish_processing']['count']) }}</h3>
                                    @if($activityStats['fish_processing']['change']['direction'] === 'up')
                                        <span class="text-xs text-success font-medium">+{{ $activityStats['fish_processing']['change']['value'] }}%</span>
                                    @elseif($activityStats['fish_processing']['change']['direction'] === 'down')
                                        <span class="text-xs text-error font-medium">-{{ $activityStats['fish_processing']['change']['value'] }}%</span>
                                    @else
                                        <span class="text-xs text-base-content/40">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 1 --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mb-6">
            {{-- Barangay Distribution Chart - Wider --}}
            <div class="card bg-base-100 shadow-sm lg:col-span-2">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-base-content">Fisherfolk by Barangay</h3>
                        <div class="dropdown dropdown-end">
                            <button class="btn btn-ghost btn-xs btn-square">
                                <span class="icon-[tabler--dots-vertical] size-4"></span>
                            </button>
                        </div>
                    </div>
                    <div id="barangayChart"></div>
                </div>
            </div>

            {{-- Gender Distribution Chart --}}
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-base-content">Gender Distribution</h3>
                        <div class="dropdown dropdown-end">
                            <button class="btn btn-ghost btn-xs btn-square">
                                <span class="icon-[tabler--dots-vertical] size-4"></span>
                            </button>
                        </div>
                    </div>
                    <div id="genderChart"></div>
                </div>
            </div>
        </div>

        {{-- Charts Row 2 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
            {{-- Age Group Distribution Chart --}}
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-base-content">Age Group Distribution</h3>
                        <span class="badge badge-soft badge-primary badge-sm">Demographics</span>
                    </div>
                    <div id="ageGroupChart"></div>
                </div>
            </div>

            {{-- Activity Categories Chart --}}
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-base-content">Activity Categories</h3>
                        <span class="badge badge-soft badge-secondary badge-sm">Livelihood</span>
                    </div>
                    <div id="categoryChart"></div>
                </div>
            </div>
        </div>

        {{-- Recent Fisherfolk Table --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body p-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <div>
                        <h3 class="font-semibold text-base-content">Recently Registered</h3>
                        <p class="text-sm text-base-content/60">Latest fisherfolk registrations</p>
                    </div>
                    @if(auth()->user()->hasPermission('fisherfolk', 'view'))
                    <a href="{{ route('fisherfolk.index') }}" class="btn btn-primary btn-sm gap-2">
                        <span class="icon-[tabler--eye] size-4"></span>
                        View All
                    </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>
                                    <div class="flex items-center gap-2">
                                        <span class="icon-[tabler--id] size-4 text-base-content/50"></span>
                                        ID Number
                                    </div>
                                </th>
                                <th>
                                    <div class="flex items-center gap-2">
                                        <span class="icon-[tabler--user] size-4 text-base-content/50"></span>
                                        Full Name
                                    </div>
                                </th>
                                <th>
                                    <div class="flex items-center gap-2">
                                        <span class="icon-[tabler--map-pin] size-4 text-base-content/50"></span>
                                        Barangay
                                    </div>
                                </th>
                                <th>Sex</th>
                                <th>
                                    <div class="flex items-center gap-2">
                                        <span class="icon-[tabler--calendar] size-4 text-base-content/50"></span>
                                        Date Registered
                                    </div>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentFisherfolk as $person)
                            <tr class="hover">
                                <td>
                                    <span class="font-mono text-sm font-medium">{{ $person->id_number }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar avatar-placeholder">
                                            <div class="bg-base-300 text-base-content w-8 rounded-full">
                                                <span class="text-xs">{{ substr($person->first_name, 0, 1) }}{{ substr($person->last_name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <span>{{ $person->full_name }}</span>
                                    </div>
                                </td>
                                <td class="text-base-content/70">{{ $person->address }}</td>
                                <td>
                                    <span class="badge badge-sm {{ $person->sex == 'Male' ? 'badge-info badge-soft' : 'badge-secondary badge-soft' }}">
                                        {{ $person->sex }}
                                    </span>
                                </td>
                                <td class="text-base-content/60 text-sm">{{ $person->date_registered->format('M d, Y') }}</td>
                                <td>
                                    @if(auth()->user()->hasPermission('fisherfolk', 'view'))
                                    <a href="{{ route('fisherfolk.show', $person) }}" class="btn btn-ghost btn-xs btn-square" title="View">
                                        <span class="icon-[tabler--eye] size-4"></span>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="icon-[tabler--users-minus] size-12 text-base-content/30"></span>
                                        <p class="text-base-content/60">No fisherfolk registered yet</p>
                                        @if(auth()->user()->hasPermission('fisherfolk', 'create'))
                                        <a href="{{ route('fisherfolk.create') }}" class="btn btn-primary btn-sm mt-2">
                                            Register First Fisherfolk
                                        </a>
                                        @endif
                                    </div>
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
    <script>
        // Initialize charts when page loads
        if (typeof window.initDashboardCharts === 'function') {
            window.initDashboardCharts();
        }
    </script>
    @endpush
</x-app-layout>
