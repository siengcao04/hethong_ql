<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SinhVien;
use App\Models\MonHoc;
use App\Models\GiangVien;
use App\Models\DangKyMonHoc;
use App\Models\Diem;

class DiemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinhViens = SinhVien::all();
        $monHocs = MonHoc::all();
        $giangViens = GiangVien::all();

        if ($sinhViens->isEmpty() || $monHocs->isEmpty() || $giangViens->isEmpty()) {
            $this->command->warn('Cần có sinh viên, môn học và giảng viên trước khi tạo điểm!');
            return;
        }

        $count = 0;
        
        // Tạo điểm cho các sinh viên khóa 2021 (Học kỳ 1, năm 2021-2022)
        foreach ($sinhViens->where('khoa_hoc', '2021-2025')->take(20) as $sinhVien) {
            // Mỗi sinh viên đăng ký 4-5 môn học
            $monHocsRandom = $monHocs->random(rand(4, 5));
            
            foreach ($monHocsRandom as $monHoc) {
                // Chọn giảng viên ngẫu nhiên
                $giangVien = $giangViens->random();
                
                // Tạo đăng ký môn học
                $dangKyMonHoc = DangKyMonHoc::create([
                    'sinh_vien_id' => $sinhVien->id,
                    'mon_hoc_id' => $monHoc->id,
                    'giang_vien_id' => $giangVien->id,
                    'hoc_ky' => 1,
                    'nam_hoc' => '2021-2022',
                ]);

                // Tạo điểm ngẫu nhiên
                // Sinh điểm với phân phối thực tế: 
                // - 20% giỏi (8-10)
                // - 40% khá (6.5-7.9)
                // - 30% trung bình (5-6.4)
                // - 10% yếu (0-4.9)
                
                $rand = rand(1, 100);
                
                if ($rand <= 20) {
                    // Giỏi
                    $diemCC = rand(70, 100) / 10;
                    $diemGK = rand(75, 100) / 10;
                    $diemCK = rand(80, 100) / 10;
                    $soBuoiNghi = rand(0, 2);
                } elseif ($rand <= 60) {
                    // Khá
                    $diemCC = rand(60, 80) / 10;
                    $diemGK = rand(65, 85) / 10;
                    $diemCK = rand(65, 85) / 10;
                    $soBuoiNghi = rand(0, 3);
                } elseif ($rand <= 90) {
                    // Trung bình
                    $diemCC = rand(50, 70) / 10;
                    $diemGK = rand(50, 70) / 10;
                    $diemCK = rand(50, 70) / 10;
                    $soBuoiNghi = rand(1, 5);
                } else {
                    // Yếu
                    $diemCC = rand(20, 50) / 10;
                    $diemGK = rand(20, 50) / 10;
                    $diemCK = rand(20, 50) / 10;
                    $soBuoiNghi = rand(3, 10);
                }

                // Tạo điểm (model tự động tính điểm trung bình và trạng thái)
                Diem::create([
                    'dang_ky_mon_hoc_id' => $dangKyMonHoc->id,
                    'diem_chuyen_can' => round($diemCC, 1),
                    'diem_giua_ky' => round($diemGK, 1),
                    'diem_cuoi_ky' => round($diemCK, 1),
                    'so_buoi_nghi' => $soBuoiNghi,
                ]);

                $count++;
            }
        }

        $this->command->info('Đã tạo ' . $count . ' bản ghi điểm');
    }
}
