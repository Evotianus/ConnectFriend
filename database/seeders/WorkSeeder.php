<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $works = [
            'Web Developer',
            'Mobile Developer',
            'Desktop Developer',
            'DevOps Engineer',
            'Database Administrator',
        ];

        foreach ($works as $key => $work) {
            Work::create(['name' => $work]);
        }

        for ($i = 0; $i < 10; $i++) {
            DB::table('users_works')->insert([
                'user_id' => rand(1, 3),
                'work_id' => rand(1, 5),
            ]);
        }
    }
}
