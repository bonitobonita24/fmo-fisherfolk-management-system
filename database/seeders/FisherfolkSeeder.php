<?php

namespace Database\Seeders;

use App\Models\Fisherfolk;
use Illuminate\Database\Seeder;

class FisherfolkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample fisherfolk data
        $sampleData = [
            [
                'id_number' => 'MR-CL-001234-2015',
                'full_name' => 'Juan Dela Cruz',
                'date_of_birth' => '1975-05-15',
                'address' => 'WAWA',
                'sex' => 'Male',
                'contact_number' => '09171234567',
                'rsbsa' => 'RSBSA-001234',
                'boat_owneroperator' => true,
                'capture_fishing' => true,
            ],
            [
                'id_number' => 'MR-CL-001235-2015',
                'full_name' => 'Maria Santos',
                'date_of_birth' => '1982-08-22',
                'address' => 'SANTA ISABEL',
                'sex' => 'Female',
                'contact_number' => '09281234567',
                'rsbsa' => 'RSBSA-001235',
                'vendor' => true,
                'fish_processing' => true,
            ],
            [
                'id_number' => 'MR-CL-001236-2015',
                'full_name' => 'Pedro Reyes',
                'date_of_birth' => '1990-03-10',
                'address' => 'WAWA',
                'sex' => 'Male',
                'contact_number' => '09391234567',
                'rsbsa' => 'RSBSA-001236',
                'capture_fishing' => true,
                'gleaning' => true,
            ],
            [
                'id_number' => 'MR-CL-001237-2015',
                'full_name' => 'Ana Garcia',
                'date_of_birth' => '1988-11-05',
                'address' => 'BARUYAN',
                'sex' => 'Female',
                'contact_number' => '09401234567',
                'rsbsa' => 'RSBSA-001237',
                'aquaculture' => true,
            ],
            [
                'id_number' => 'MR-CL-001238-2015',
                'full_name' => 'Jose Martinez',
                'date_of_birth' => '1970-01-20',
                'address' => 'SANTA ISABEL',
                'sex' => 'Male',
                'contact_number' => '09511234567',
                'rsbsa' => 'RSBSA-001238',
                'boat_owneroperator' => true,
                'capture_fishing' => true,
                'vendor' => true,
            ],
        ];

        foreach ($sampleData as $data) {
            Fisherfolk::create($data);
        }

        $this->command->info('Sample fisherfolk data seeded successfully!');
    }
}
