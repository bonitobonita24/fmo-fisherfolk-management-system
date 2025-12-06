<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Add New Fisherfolk') }}
            </h2>
            <a href="{{ route('fisherfolk.index') }}" class="btn btn-ghost btn-sm gap-2">
                <span class="icon-[tabler--arrow-left] size-4"></span>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-error mb-6">
                            <span class="icon-[tabler--alert-circle] size-5"></span>
                            <div>
                                <h3 class="font-bold">Whoops! There were some problems with your input.</h3>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('fisherfolk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-base-content mb-4 pb-2 border-b border-base-300">
                                Basic Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- ID Number -->
                                <div class="form-control">
                                    <x-input-label for="id_number" :value="__('ID Number')" />
                                    <x-text-input id="id_number" name="id_number" type="text" class="w-full" :value="old('id_number')" required placeholder="e.g., MR-CL-001234-2024" />
                                    <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                                </div>

                                <!-- Full Name -->
                                <div class="form-control">
                                    <x-input-label for="full_name" :value="__('Full Name')" />
                                    <x-text-input id="full_name" name="full_name" type="text" class="w-full" :value="old('full_name')" required placeholder="Last Name, First Name Middle Name" />
                                    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                                </div>

                                <!-- Date of Birth -->
                                <div class="form-control">
                                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="w-full" :value="old('date_of_birth')" required />
                                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                </div>

                                <!-- Sex -->
                                <div class="form-control">
                                    <x-input-label for="sex" :value="__('Sex')" />
                                    <select id="sex" name="sex" class="select select-bordered w-full" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                                </div>

                                <!-- Address/Barangay -->
                                <div class="form-control">
                                    <x-input-label for="address" :value="__('Barangay')" />
                                    <select id="address" name="address" class="select select-bordered w-full" required>
                                        <option value="">Select Barangay</option>
                                        @php
                                            $barangays = [
                                                'BALINGAYAN', 'BALITE', 'BARUYAN', 'BATINO', 'BAYANAN I', 'BAYANAN II',
                                                'BIGA', 'BONDOC', 'BUCAYAO', 'BUHUAN', 'BULUSAN', 'CALERO', 'CAMANSIHAN',
                                                'CAMILMIL', 'CANUBING I', 'CANUBING II', 'COMUNAL', 'GUINOBATAN',
                                                'GULOD', 'GUTAD', 'IBABA EAST', 'IBABA WEST', 'ILAYA', 'LALUD',
                                                'LAZARETO', 'LIBIS', 'LUMANG BAYAN', 'MAHAL NA PANGALAN', 'MAIDLANG',
                                                'MALAD', 'MALAMIG', 'MANAGPI', 'MASIPIT', 'NAG-IBA I', 'NAG-IBA II',
                                                'NAVOTAS', 'PACHOCA', 'PALHI', 'PANGGALAAN', 'PARANG', 'PATAS',
                                                'PERSONAS', 'PUTINGTUBIG', 'SALONG', 'SAN ANTONIO', 'SAN VICENTE NORTH',
                                                'SAN VICENTE SOUTH', 'SANTA CRUZ', 'SANTA ISABEL', 'SANTA MARIA VILLAGE',
                                                'SANTA RITA', 'SANTO NIÑO', 'SAPUL', 'SILONAY', 'SUQUI', 'TAWAGAN',
                                                'TAWIRAN', 'TIBAG', 'WAWA'
                                            ];
                                        @endphp
                                        @foreach($barangays as $barangay)
                                            <option value="{{ $barangay }}" {{ old('address') == $barangay ? 'selected' : '' }}>{{ $barangay }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <!-- Contact Number -->
                                <div class="form-control">
                                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                                    <x-text-input id="contact_number" name="contact_number" type="text" class="w-full" :value="old('contact_number')" placeholder="09XX-XXX-XXXX" />
                                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                                </div>

                                <!-- RSBSA Number -->
                                <div class="form-control md:col-span-2">
                                    <x-input-label for="rsbsa" :value="__('RSBSA Number (Optional)')" />
                                    <x-text-input id="rsbsa" name="rsbsa" type="text" class="w-full" :value="old('rsbsa')" placeholder="Registry System for Basic Sectors in Agriculture" />
                                    <x-input-error :messages="$errors->get('rsbsa')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Activity Categories Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-base-content mb-4 pb-2 border-b border-base-300">
                                Fishing Activity Categories
                            </h3>
                            <p class="text-sm text-base-content/60 mb-4">Select all applicable categories:</p>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <!-- Boat Owner/Operator -->
                                <label class="flex items-center p-3 border border-base-300 rounded-lg hover:bg-base-200 cursor-pointer transition">
                                    <input type="checkbox" name="boat_owneroperator" value="1" {{ old('boat_owneroperator') ? 'checked' : '' }} class="checkbox checkbox-primary checkbox-sm">
                                    <span class="ml-3 text-sm text-base-content">Boat Owner/Operator</span>
                                </label>

                                <!-- Capture Fishing -->
                                <label class="flex items-center p-3 border border-base-300 rounded-lg hover:bg-base-200 cursor-pointer transition">
                                    <input type="checkbox" name="capture_fishing" value="1" {{ old('capture_fishing') ? 'checked' : '' }} class="checkbox checkbox-primary checkbox-sm">
                                    <span class="ml-3 text-sm text-base-content">Capture Fishing</span>
                                </label>

                                <!-- Gleaning -->
                                <label class="flex items-center p-3 border border-base-300 rounded-lg hover:bg-base-200 cursor-pointer transition">
                                    <input type="checkbox" name="gleaning" value="1" {{ old('gleaning') ? 'checked' : '' }} class="checkbox checkbox-primary checkbox-sm">
                                    <span class="ml-3 text-sm text-base-content">Gleaning</span>
                                </label>

                                <!-- Vendor -->
                                <label class="flex items-center p-3 border border-base-300 rounded-lg hover:bg-base-200 cursor-pointer transition">
                                    <input type="checkbox" name="vendor" value="1" {{ old('vendor') ? 'checked' : '' }} class="checkbox checkbox-primary checkbox-sm">
                                    <span class="ml-3 text-sm text-base-content">Vendor</span>
                                </label>

                                <!-- Fish Processing -->
                                <label class="flex items-center p-3 border border-base-300 rounded-lg hover:bg-base-200 cursor-pointer transition">
                                    <input type="checkbox" name="fish_processing" value="1" {{ old('fish_processing') ? 'checked' : '' }} class="checkbox checkbox-primary checkbox-sm">
                                    <span class="ml-3 text-sm text-base-content">Fish Processing</span>
                                </label>

                                <!-- Aquaculture -->
                                <label class="flex items-center p-3 border border-base-300 rounded-lg hover:bg-base-200 cursor-pointer transition">
                                    <input type="checkbox" name="aquaculture" value="1" {{ old('aquaculture') ? 'checked' : '' }} class="checkbox checkbox-primary checkbox-sm">
                                    <span class="ml-3 text-sm text-base-content">Aquaculture</span>
                                </label>
                            </div>
                        </div>

                        <!-- Photo Uploads Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-base-content mb-4 pb-2 border-b border-base-300">
                                Photo Uploads
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Profile Image -->
                                <div class="form-control">
                                    <x-input-label for="image" :value="__('Profile Photo')" />
                                    <div class="mt-2 flex items-center gap-4">
                                        <div id="image-preview" class="avatar placeholder">
                                            <div class="bg-base-300 text-base-content/40 rounded-lg w-24 h-24 flex items-center justify-center">
                                                <span class="icon-[tabler--user] size-12"></span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" id="image" name="image" accept="image/jpeg,image/jpg,image/png" class="file-input file-input-bordered file-input-primary w-full" onchange="previewImage(this, 'image-preview')">
                                            <p class="mt-1 text-xs text-base-content/60">JPG, JPEG, PNG up to 2MB</p>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>

                                <!-- Signature -->
                                <div class="form-control">
                                    <x-input-label for="signature" :value="__('Signature')" />
                                    <div class="mt-2 flex items-center gap-4">
                                        <div id="signature-preview" class="avatar placeholder">
                                            <div class="bg-base-300 text-base-content/40 rounded-lg w-24 h-24 flex items-center justify-center">
                                                <span class="icon-[tabler--signature] size-12"></span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" id="signature" name="signature" accept="image/jpeg,image/jpg,image/png" class="file-input file-input-bordered file-input-secondary w-full" onchange="previewImage(this, 'signature-preview')">
                                            <p class="mt-1 text-xs text-base-content/60">JPG, JPEG, PNG up to 2MB</p>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('signature')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-base-300">
                            <a href="{{ route('fisherfolk.index') }}" class="btn btn-ghost">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary gap-2">
                                <span class="icon-[tabler--check] size-4"></span>
                                {{ __('Save Fisherfolk') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<div class="rounded-lg w-24 h-24 overflow-hidden"><img src="${e.target.result}" class="w-full h-full object-cover"></div>`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
</x-app-layout>
