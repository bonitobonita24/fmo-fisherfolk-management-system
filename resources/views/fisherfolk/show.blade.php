<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Fisherfolk Details') }}
            </h2>
            <div class="flex gap-2">
                @if(auth()->user()->hasPermission('fisherfolk', 'update'))
                <a href="{{ route('fisherfolk.edit', $fisherfolk->id_number) }}" class="btn btn-secondary btn-sm gap-2">
                    <span class="icon-[tabler--edit] size-4"></span>
                    Edit
                </a>
                @endif
                <a href="{{ route('fisherfolk.index') }}" class="btn btn-ghost btn-sm gap-2">
                    <span class="icon-[tabler--arrow-left] size-4"></span>
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <!-- Header with Photo -->
                    <div class="flex flex-col md:flex-row gap-6 mb-8 pb-6 border-b border-base-300">
                        <!-- Profile Photo -->
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <div class="w-32 h-32 rounded-lg bg-base-300">
                                    @if($fisherfolk->image)
                                        <img src="{{ $fisherfolk->image_url }}" alt="{{ $fisherfolk->full_name }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-base-content/40">
                                            <span class="icon-[tabler--user] size-16"></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Basic Info Header -->
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-base-content">{{ $fisherfolk->full_name }}</h3>
                            <p class="text-lg text-primary font-semibold mt-1">{{ $fisherfolk->id_number }}</p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="badge {{ $fisherfolk->sex == 'Male' ? 'badge-info' : 'badge-secondary' }}">
                                    {{ $fisherfolk->sex }}
                                </span>
                                <span class="badge badge-success">
                                    {{ $fisherfolk->address }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-base-content mb-4">Personal Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm text-base-content/60">Date of Birth</p>
                                <p class="text-lg font-medium text-base-content">
                                    {{ $fisherfolk->date_of_birth->format('F d, Y') }}
                                </p>
                                <p class="text-sm text-base-content/60">
                                    ({{ $fisherfolk->date_of_birth->age }} years old)
                                </p>
                            </div>
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm text-base-content/60">Contact Number</p>
                                <p class="text-lg font-medium text-base-content">
                                    {{ $fisherfolk->contact_number ?: 'Not provided' }}
                                </p>
                            </div>
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm text-base-content/60">RSBSA Number</p>
                                <p class="text-lg font-medium text-base-content">
                                    {{ $fisherfolk->rsbsa ?: 'Not registered' }}
                                </p>
                            </div>
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm text-base-content/60">Barangay</p>
                                <p class="text-lg font-medium text-base-content">
                                    {{ $fisherfolk->address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Categories -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-base-content mb-4">Fishing Activity Categories</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="flex items-center p-3 rounded-lg {{ $fisherfolk->boat_owneroperator ? 'bg-success/10' : 'bg-base-200' }}">
                                @if($fisherfolk->boat_owneroperator)
                                    <span class="icon-[tabler--circle-check-filled] size-5 text-success mr-2"></span>
                                @else
                                    <span class="icon-[tabler--circle-x] size-5 text-base-content/30 mr-2"></span>
                                @endif
                                <span class="text-sm {{ $fisherfolk->boat_owneroperator ? 'text-success font-medium' : 'text-base-content/50' }}">Boat Owner/Operator</span>
                            </div>

                            <div class="flex items-center p-3 rounded-lg {{ $fisherfolk->capture_fishing ? 'bg-success/10' : 'bg-base-200' }}">
                                @if($fisherfolk->capture_fishing)
                                    <span class="icon-[tabler--circle-check-filled] size-5 text-success mr-2"></span>
                                @else
                                    <span class="icon-[tabler--circle-x] size-5 text-base-content/30 mr-2"></span>
                                @endif
                                <span class="text-sm {{ $fisherfolk->capture_fishing ? 'text-success font-medium' : 'text-base-content/50' }}">Capture Fishing</span>
                            </div>

                            <div class="flex items-center p-3 rounded-lg {{ $fisherfolk->gleaning ? 'bg-success/10' : 'bg-base-200' }}">
                                @if($fisherfolk->gleaning)
                                    <span class="icon-[tabler--circle-check-filled] size-5 text-success mr-2"></span>
                                @else
                                    <span class="icon-[tabler--circle-x] size-5 text-base-content/30 mr-2"></span>
                                @endif
                                <span class="text-sm {{ $fisherfolk->gleaning ? 'text-success font-medium' : 'text-base-content/50' }}">Gleaning</span>
                            </div>

                            <div class="flex items-center p-3 rounded-lg {{ $fisherfolk->vendor ? 'bg-success/10' : 'bg-base-200' }}">
                                @if($fisherfolk->vendor)
                                    <span class="icon-[tabler--circle-check-filled] size-5 text-success mr-2"></span>
                                @else
                                    <span class="icon-[tabler--circle-x] size-5 text-base-content/30 mr-2"></span>
                                @endif
                                <span class="text-sm {{ $fisherfolk->vendor ? 'text-success font-medium' : 'text-base-content/50' }}">Vendor</span>
                            </div>

                            <div class="flex items-center p-3 rounded-lg {{ $fisherfolk->fish_processing ? 'bg-success/10' : 'bg-base-200' }}">
                                @if($fisherfolk->fish_processing)
                                    <span class="icon-[tabler--circle-check-filled] size-5 text-success mr-2"></span>
                                @else
                                    <span class="icon-[tabler--circle-x] size-5 text-base-content/30 mr-2"></span>
                                @endif
                                <span class="text-sm {{ $fisherfolk->fish_processing ? 'text-success font-medium' : 'text-base-content/50' }}">Fish Processing</span>
                            </div>

                            <div class="flex items-center p-3 rounded-lg {{ $fisherfolk->aquaculture ? 'bg-success/10' : 'bg-base-200' }}">
                                @if($fisherfolk->aquaculture)
                                    <span class="icon-[tabler--circle-check-filled] size-5 text-success mr-2"></span>
                                @else
                                    <span class="icon-[tabler--circle-x] size-5 text-base-content/30 mr-2"></span>
                                @endif
                                <span class="text-sm {{ $fisherfolk->aquaculture ? 'text-success font-medium' : 'text-base-content/50' }}">Aquaculture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Signature -->
                    @if($fisherfolk->signature)
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-base-content mb-4">Signature</h4>
                        <div class="bg-base-200 rounded-lg p-4 inline-block">
                            <img src="{{ asset('storage/uploads/' . $fisherfolk->signature) }}" alt="Signature" class="max-h-24">
                        </div>
                    </div>
                    @endif

                    <!-- Registration Info -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-base-content mb-4">Registration Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm text-base-content/60">Date Registered</p>
                                <p class="text-lg font-medium text-base-content">
                                    {{ $fisherfolk->date_registered->format('F d, Y') }}
                                </p>
                            </div>
                            <div class="bg-base-200 rounded-lg p-4">
                                <p class="text-sm text-base-content/60">Last Updated</p>
                                <p class="text-lg font-medium text-base-content">
                                    {{ $fisherfolk->date_updated ? $fisherfolk->date_updated->format('F d, Y') : 'Never' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-base-300">
                        @if(auth()->user()->hasPermission('fisherfolk', 'update'))
                        <a href="{{ route('fisherfolk.edit', $fisherfolk->id_number) }}" class="btn btn-secondary gap-2">
                            <span class="icon-[tabler--edit] size-4"></span>
                            Edit Record
                        </a>
                        @endif
                        
                        @if(auth()->user()->hasPermission('fisherfolk', 'delete'))
                        <form action="{{ route('fisherfolk.destroy', $fisherfolk->id_number) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error gap-2">
                                <span class="icon-[tabler--trash] size-4"></span>
                                Delete Record
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
