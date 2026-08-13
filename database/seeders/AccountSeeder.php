<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Seed the internal and public accounts.
     */
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Admin Internal',
                'email' => 'internal@example.com',
                'password' => 'password',
                'role' => 'internal',
            ],
            [
                'name' => 'Pengguna Publik',
                'email' => 'public@example.com',
                'password' => 'password',
                'role' => 'user',
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::query()->firstOrNew([
                'email' => $account['email'],
            ]);

            $user->forceFill([
                'name' => $account['name'],
                'email_verified_at' => now(),
                'password' => Hash::make($account['password']),
                'role' => $account['role'],
            ])->save();
        }
    }
}
