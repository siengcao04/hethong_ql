<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi các Seeders theo thứ tự
        $this->call([
            RoleSeeder::class,
            KhoaSeeder::class,
            LopSeeder::class,
            MonHocSeeder::class,
            GiangVienSeeder::class,
            SinhVienSeeder::class,
            DiemSeeder::class,
            DuDoanHocTapSeeder::class,
        ]);

        // Tạo tài khoản Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@hethong.com',
            'password' => Hash::make('123456'),
            'role_id' => 1, // admin
        ]);

        $this->command->info(' Hoàn thành seeding database!');
    }
}
