<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Diem;
use Illuminate\Support\Facades\Storage;

class ExportTrainingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:export-training-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export dữ liệu điểm để training AI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Đang export dữ liệu training...');

        // Lấy tất cả dữ liệu điểm
        $diems = Diem::with(['dangKyMonHoc.monHoc', 'dangKyMonHoc.sinhVien'])
            ->whereNotNull('diem_chuyen_can')
            ->whereNotNull('diem_giua_ky')
            ->whereNotNull('diem_cuoi_ky')
            ->get();

        if ($diems->isEmpty()) {
            $this->error('Không có dữ liệu điểm để export!');
            return 1;
        }

        // Chuẩn bị dữ liệu CSV
        $csvData = [];
        $csvData[] = [
            'diem_chuyen_can',
            'diem_giua_ky',
            'diem_cuoi_ky',
            'so_buoi_nghi',
            'so_tin_chi',
            'trang_thai'
        ];

        foreach ($diems as $diem) {
            // Tính trạng thái nếu chưa có
            $trangThai = $diem->trang_thai;
            if (empty($trangThai) || $trangThai === 'Chưa xác định') {
                $dtb = ($diem->diem_chuyen_can * 0.1) + 
                       ($diem->diem_giua_ky * 0.3) + 
                       ($diem->diem_cuoi_ky * 0.6);
                
                if ($dtb >= 8) {
                    $trangThai = 'Giỏi';
                } elseif ($dtb >= 6.5) {
                    $trangThai = 'Khá';
                } elseif ($dtb >= 5) {
                    $trangThai = 'Trung bình';
                } else {
                    $trangThai = 'Yếu';
                }
            }
            
            $csvData[] = [
                $diem->diem_chuyen_can ?? 0,
                $diem->diem_giua_ky ?? 0,
                $diem->diem_cuoi_ky ?? 0,
                $diem->so_buoi_nghi ?? 0,
                $diem->dangKyMonHoc->monHoc->so_tin_chi ?? 3,
                $trangThai
            ];
        }

        // Lưu file CSV
        $csvPath = base_path('ai/data/training_data.csv');
        $fp = fopen($csvPath, 'w');
        
        foreach ($csvData as $row) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);

        $this->info('✅ Đã export ' . ($diems->count()) . ' bản ghi vào: ' . $csvPath);
        
        // Export thêm file JSON cho metadata
        $metadata = [
            'total_records' => $diems->count(),
            'exported_at' => now()->toDateTimeString(),
            'features' => [
                'diem_chuyen_can' => 'Điểm chuyên cần (0-10)',
                'diem_giua_ky' => 'Điểm giữa kỳ (0-10)',
                'diem_cuoi_ky' => 'Điểm cuối kỳ (0-10)',
                'so_buoi_nghi' => 'Số buổi nghỉ',
                'so_tin_chi' => 'Số tín chỉ môn học'
            ],
            'target' => 'trang_thai (Giỏi, Khá, Trung bình, Yếu)'
        ];

        $jsonPath = base_path('ai/data/metadata.json');
        file_put_contents($jsonPath, json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('✅ Đã tạo metadata: ' . $jsonPath);

        return 0;
    }
}
