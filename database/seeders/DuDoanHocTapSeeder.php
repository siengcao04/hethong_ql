<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DuDoanHocTap;
use App\Models\Diem;

class DuDoanHocTapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy một số điểm đã có để tạo dự đoán
        $diems = Diem::with(['dangKyMonHoc.sinhVien', 'dangKyMonHoc.monHoc'])
            ->whereNotNull('diem_trung_binh')
            ->take(20)
            ->get();

        foreach ($diems as $diem) {
            $sinhVien = $diem->dangKyMonHoc->sinhVien;
            $monHoc = $diem->dangKyMonHoc->monHoc;
            
            // Tính độ tin cậy dựa trên trạng thái
            $doTinCay = match($diem->trang_thai) {
                'Giỏi' => rand(90, 100),
                'Khá' => rand(80, 95),
                'Trung bình' => rand(70, 85),
                'Yếu' => rand(60, 80),
                default => 75
            };

            DuDoanHocTap::create([
                'sinh_vien_id' => $sinhVien->id,
                'mon_hoc_id' => $monHoc->id,
                'du_doan' => $diem->trang_thai,
                'do_tin_cay' => $doTinCay,
                'thoi_gian_du_doan' => now()->subDays(rand(1, 30))
            ]);
        }

        $this->command->info(' Đã tạo ' . DuDoanHocTap::count() . ' dự đoán học tập');
    }
}
