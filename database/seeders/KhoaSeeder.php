<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Khoa;

class KhoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $khoas = [
            ['ma_khoa' => 'CNTT', 'ten_khoa' => 'Công nghệ Thông tin', 'mo_ta' => 'Khoa Công nghệ Thông tin'],
            ['ma_khoa' => 'KT', 'ten_khoa' => 'Kinh tế', 'mo_ta' => 'Khoa Kinh tế'],
            ['ma_khoa' => 'NN', 'ten_khoa' => 'Ngoại ngữ', 'mo_ta' => 'Khoa Ngoại ngữ'],
        ];

        foreach ($khoas as $khoa) {
            Khoa::create($khoa);
        }
    }
}
