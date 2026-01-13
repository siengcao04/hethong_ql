<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class AIService
{
    private $pythonPath;
    private $scriptPath;

    public function __construct()
    {
        $this->pythonPath = 'python'; // Hoặc đường dẫn đầy đủ: C:\Python\python.exe
        $this->scriptPath = base_path('ai/predict.py');
    }

    /**
     * Dự đoán kết quả học tập
     * 
     * @param float $diemChuyenCan
     * @param float $diemGiuaKy
     * @param float $diemCuoiKy
     * @param int $soBuoiNghi
     * @param int $soTinChi
     * @return array|null
     */
    public function predictGrade($diemChuyenCan, $diemGiuaKy, $diemCuoiKy, $soBuoiNghi, $soTinChi)
    {
        try {
            // Xây dựng command
            $command = sprintf(
                '%s %s %s %s %s %s %s',
                $this->pythonPath,
                escapeshellarg($this->scriptPath),
                escapeshellarg($diemChuyenCan),
                escapeshellarg($diemGiuaKy),
                escapeshellarg($diemCuoiKy),
                escapeshellarg($soBuoiNghi),
                escapeshellarg($soTinChi)
            );

            // Chạy command và lấy output
            $output = shell_exec($command . ' 2>&1');

            if (empty($output)) {
                Log::error('AIService: No output from Python script');
                return null;
            }

            // Lấy dòng cuối cùng chứa JSON (bỏ qua warnings từ sklearn)
            $lines = array_filter(explode("\n", trim($output)), 'strlen');
            $jsonLine = end($lines);

            // Parse JSON output
            $result = json_decode($jsonLine, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('AIService: Failed to parse JSON', [
                    'output' => $output,
                    'json_line' => $jsonLine,
                    'error' => json_last_error_msg()
                ]);
                return null;
            }

            // Kiểm tra có lỗi từ Python
            if (isset($result['error'])) {
                Log::error('AIService: Python script error', ['error' => $result['error']]);
                return null;
            }

            return $result;

        } catch (Exception $e) {
            Log::error('AIService: Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Dự đoán cho sinh viên dựa trên điểm hiện tại
     * 
     * @param \App\Models\SinhVien $sinhVien
     * @param int $monHocId
     * @param float $diemCC
     * @param float $diemGK
     * @param float $diemCK
     * @param int $soBuoiNghi
     * @return array|null
     */
    public function predictForStudent($sinhVien, $monHocId, $diemCC, $diemGK, $diemCK, $soBuoiNghi)
    {
        $monHoc = \App\Models\MonHoc::find($monHocId);
        if (!$monHoc) {
            return null;
        }

        return $this->predictGrade(
            $diemCC,
            $diemGK,
            $diemCK,
            $soBuoiNghi,
            $monHoc->so_tin_chi
        );
    }

    /**
     * Kiểm tra xem AI model có sẵn sàng không
     * 
     * @return bool
     */
    public function isModelReady()
    {
        $modelPath = base_path('ai/models/grade_predictor.pkl');
        return file_exists($modelPath);
    }

    /**
     * Lấy thông tin model
     * 
     * @return array|null
     */
    public function getModelInfo()
    {
        $infoPath = base_path('ai/models/grade_predictor_info.json');
        
        if (!file_exists($infoPath)) {
            return null;
        }

        $content = file_get_contents($infoPath);
        return json_decode($content, true);
    }
}
