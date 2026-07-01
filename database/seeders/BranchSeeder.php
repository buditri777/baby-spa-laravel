<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'id'         => 'branch-pusat-001',
                'code'       => 'PUSAT',
                'name'       => 'Cabang Pusat',
                'address'    => 'Jl. Utama No. 1, Jakarta',
                'phone'      => '021-1234567',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 'branch-cabang-002',
                'code'       => 'CAB2',
                'name'       => 'Cabang 2',
                'address'    => 'Jl. Kedua No. 2, Jakarta',
                'phone'      => '021-7654321',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($branches as $branch) {
            DB::table('branches')->updateOrInsert(
                ['id' => $branch['id']],
                $branch
            );
        }

        $this->command->info('Branches seeded: ' . count($branches));
    }
}
