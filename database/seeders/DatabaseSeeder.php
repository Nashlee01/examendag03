<?php

namespace Database\Seeders;

use App\Models\Behandeling;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@kniploket.local',
            'role' => 'admin',
        ]);

        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@kniploket.local',
            'role' => 'student',
        ]);

        Behandeling::query()->create([
            'user_id' => $admin->id,
            'klant_naam' => 'Milan de Vries',
            'datum' => now()->addDay()->toDateString(),
            'start_tijd' => '09:00',
            'duur_minuten' => 45,
            'status' => 'gepland',
            'opmerking' => 'Knippen en stylen.',
        ]);

        Behandeling::query()->create([
            'user_id' => $student->id,
            'klant_naam' => 'Noa Smit',
            'datum' => now()->addDay()->toDateString(),
            'start_tijd' => '10:00',
            'duur_minuten' => 30,
            'status' => 'bezig',
            'opmerking' => 'Bijwerken zijkanten.',
        ]);
    }
}
