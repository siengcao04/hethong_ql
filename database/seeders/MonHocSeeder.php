<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MonHoc;

class MonHocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $monHocs = [
            ['ma_mon' => 'IT001', 'ten_mon' => 'Lập trình Cơ bản', 'so_tin_chi' => 3],
            ['ma_mon' => 'IT002', 'ten_mon' => 'Cấu trúc dữ liệu và Thuật toán', 'so_tin_chi' => 4],
            ['ma_mon' => 'IT003', 'ten_mon' => 'Cơ sở dữ liệu', 'so_tin_chi' => 3],
            ['ma_mon' => 'IT004', 'ten_mon' => 'Lập trình hướng đối tượng', 'so_tin_chi' => 3],
            ['ma_mon' => 'IT005', 'ten_mon' => 'Mạng máy tính', 'so_tin_chi' => 3],
            ['ma_mon' => 'IT006', 'ten_mon' => 'Trí tuệ nhân tạo', 'so_tin_chi' => 3],
            ['ma_mon' => 'IT007', 'ten_mon' => 'Hệ điều hành', 'so_tin_chi' => 3],
            ['ma_mon' => 'IT008', 'ten_mon' => 'Công nghệ Web', 'so_tin_chi' => 4],
            ['ma_mon' => 'MT001', 'ten_mon' => 'Toán cao cấp', 'so_tin_chi' => 3],
            ['ma_mon' => 'MT002', 'ten_mon' => 'Xác suất thống kê', 'so_tin_chi' => 3],
            ['ma_mon' => 'EC001', 'ten_mon' => 'Kinh tế vi mô', 'so_tin_chi' => 3],
            ['ma_mon' => 'EC002', 'ten_mon' => 'Kinh tế vĩ mô', 'so_tin_chi' => 3],
            ['ma_mon' => 'EN001', 'ten_mon' => 'Tiếng Anh chuyên ngành', 'so_tin_chi' => 3],
            ['ma_mon' => 'EN002', 'ten_mon' => 'Tiếng Anh giao tiếp', 'so_tin_chi' => 2],
        ];

        foreach ($monHocs as $monHoc) {
            MonHoc::create($monHoc);
        }
    }
}
