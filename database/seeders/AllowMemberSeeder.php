<?php

namespace Database\Seeders;

use App\Models\AllowedMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllowMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1;$i < 41;$i++){
            AllowedMember::create([
                'email' => 'zenianadiarifaniputri23@gmail.com',
                'organization_id' => $i,
            ]);
        }
    }
}
