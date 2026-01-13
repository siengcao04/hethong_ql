<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lop;

class LopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lops = [
            // CNTT
            ['ma_lop' => 'CNTT-K21A', 'ten_lop' => 'Công nghệ Thông tin K21A', 'khoa_id' => 1, 'khoa_hoc' => '2021-2025'],
            ['ma_lop' => 'CNTT-K21B', 'ten_lop' => 'Công nghệ Thông tin K21B', 'khoa_id' => 1, 'khoa_hoc' => '2021-2025'],
            ['ma_lop' => 'CNTT-K22', 'ten_lop' => 'Công nghệ Thông tin K22', 'khoa_id' => 1, 'khoa_hoc' => '2022-2026'],
            // Kinh tế
            ['ma_lop' => 'KT-K21A', 'ten_lop' => 'Kinh tế K21A', 'khoa_id' => 2, 'khoa_hoc' => '2021-2025'],
            ['ma_lop' => 'KT-K21B', 'ten_lop' => 'Kinh tế K21B', 'khoa_id' => 2, 'khoa_hoc' => '2021-2025'],
            // Ngoại ngữ
            ['ma_lop' => 'NN-K21', 'ten_lop' => 'Ngoại ngữ K21', 'khoa_id' => 3, 'khoa_hoc' => '2021-2025'],
            ['ma_lop' => 'NN-K22', 'ten_lop' => 'Ngoại ngữ K22', 'khoa_id' => 3, 'khoa_hoc' => '2022-2026'],
        ];

        foreach ($lops as $lop) {
            Lop::create($lop);
        }
    }
}
