<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'id'        => 'user-superadmin-001',
                'name'      => 'Super Admin',
                'email'     => 'superadmin@babyspa.test',
                'phone'     => '081111111111',
                'password'  => Hash::make('Admin123!'),
                'role'      => 'super_admin',
                'branch_id' => 'branch-pusat-001',
            ],
            [
                'id'        => 'user-owner-001',
                'name'      => 'Owner Pusat',
                'email'     => 'owner@babyspa.test',
                'phone'     => '082222222222',
                'password'  => Hash::make('Admin123!'),
                'role'      => 'owner',
                'branch_id' => 'branch-pusat-001',
            ],
            [
                'id'        => 'user-terapis-001',
                'name'      => 'Terapis Demo',
                'email'     => 'terapis@babyspa.test',
                'phone'     => '083333333333',
                'password'  => Hash::make('Admin123!'),
                'role'      => 'terapis',
                'branch_id' => 'branch-pusat-001',
            ],
            [
                'id'        => 'user-orangtua-001',
                'name'      => 'Orang Tua Demo',
                'email'     => 'orangtua@babyspa.test',
                'phone'     => '084444444444',
                'password'  => Hash::make('Admin123!'),
                'role'      => 'orang_tua',
                'branch_id' => null,
            ],
            [
                'id'        => 'user-resepsionis-001',
                'name'      => 'Resepsionis Demo',
                'email'     => 'resepsionis@babyspa.test',
                'phone'     => '085555555555',
                'password'  => Hash::make('Admin123!'),
                'role'      => 'resepsionis',
                'branch_id' => 'branch-pusat-001',
            ],
        ];

        foreach ($accounts as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::updateOrCreate(
                ['id' => $data['id']],
                array_merge($data, [
                    'is_active'         => true,
                    'phone_verified_at' => now(),
                ])
            );

            $user->syncRoles([$role]);
        }

        $this->command->info('Seeded ' . count($accounts) . ' user accounts (password: Admin123!)');
    }
}
