<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'id'           => 'svc-pijat-bayi-001',
                'name'         => 'Pijat Bayi',
                'slug'         => 'pijat-bayi',
                'description'  => 'Pijat relaksasi untuk bayi 0-12 bulan',
                'duration_min' => 60,
                'price'        => 150000,
                'category'     => 'SPA',
                'is_active'    => true,
                'branch_id'    => null,
                'created_at'   => now(),
            ],
            [
                'id'           => 'svc-senam-bayi-002',
                'name'         => 'Senam Bayi',
                'slug'         => 'senam-bayi',
                'description'  => 'Senam stimulasi motorik untuk bayi 3-12 bulan',
                'duration_min' => 45,
                'price'        => 120000,
                'category'     => 'FITNESS',
                'is_active'    => true,
                'branch_id'    => null,
                'created_at'   => now(),
            ],
            [
                'id'           => 'svc-renang-bayi-003',
                'name'         => 'Renang Bayi',
                'slug'         => 'renang-bayi',
                'description'  => 'Terapi air untuk bayi 3-18 bulan',
                'duration_min' => 30,
                'price'        => 100000,
                'category'     => 'THERAPY',
                'is_active'    => true,
                'branch_id'    => null,
                'created_at'   => now(),
            ],
            [
                'id'           => 'svc-stimulasi-004',
                'name'         => 'Stimulasi Tumbuh Kembang',
                'slug'         => 'stimulasi-tumbuh-kembang',
                'description'  => 'Stimulasi sensorik dan motorik terarah',
                'duration_min' => 60,
                'price'        => 175000,
                'category'     => 'EVALUATION',
                'is_active'    => true,
                'branch_id'    => null,
                'created_at'   => now(),
            ],
            [
                'id'           => 'svc-homecare-pijat-005',
                'name'         => 'Pijat Bayi Homecare',
                'slug'         => 'pijat-bayi-homecare',
                'description'  => 'Pijat bayi di rumah pelanggan',
                'duration_min' => 75,
                'price'        => 200000,
                'category'     => 'SPA',
                'is_active'    => true,
                'branch_id'    => null,
                'created_at'   => now(),
            ],
        ];

        foreach ($services as $svc) {
            DB::table('services')->updateOrInsert(
                ['id' => $svc['id']],
                $svc
            );
        }

        $this->command->info('Services seeded: ' . count($services));
    }
}
