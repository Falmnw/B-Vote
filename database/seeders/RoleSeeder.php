<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = ['Admin', 'Member', 'Aktivis', 'Pengurus', 'Candidate'];
        foreach($role as $r){
            Role::create([
                'name' => $r,
            ]);
        }
    }
}
