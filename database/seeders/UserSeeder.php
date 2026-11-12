<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $count = User::count();
        if ($count > 0) {
            if ($count > 1) {
                $this->command?->warn('More than one profile exists. Existing records were preserved; review them manually.');
            }

            return;
        }
        User::create([
            'username' => 'CHANGE_ME',
            'full_name' => 'Marius De Asis',
            'email' => 'change-me@example.invalid', // Editable placeholder, not a personal address.
        ]);
    }
}
