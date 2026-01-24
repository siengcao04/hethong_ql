<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AIService;
use App\Models\SinhVien;
use App\Models\MonHoc;
use App\Models\Lop;
use App\Models\DuDoanHocTap;

class AIPredictionController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    // Trang chính - Form nhập điểm dự đoán
    public function index()
    {
        $modelInfo = $this->aiService->getModelInfo();
        $isModelReady = $this->aiService->isModelReady();
        
        $sinhViens = SinhVien::with('lop')->orderBy('ma_sinh_vien')->get();
        $monHocs = MonHoc::orderBy('ten_mon')->get();
        $lops = Lop::with('khoa')->orderBy('ten_lop')->get();

        return view('admin.ai.index', compact('modelInfo', 'isModelReady', 'sinhViens', 'monHocs', 'lops'));
    }

    // Dự đoán trực tiếp từ form
    public function predict(Request $request)
    {
        $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_viens,id',
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'diem_chuyen_can' => 'required|numeric|min:0|max:10',
            'diem_giua_ky' => 'required|numeric|min:0|max:10',
            'diem_cuoi_ky' => 'required|numeric|min:0|max:10',
            'so_buoi_nghi' => 'required|integer|min:0',
            'so_tin_chi' => 'required|integer|min:1|max:6',
        ], [
            'sinh_vien_id.required' => 'Vui lòng chọn sinh viên',
            'mon_hoc_id.required' => 'Vui lòng chọn môn học',
            'diem_chuyen_can.required' => 'Vui lòng nhập điểm chuyên cần',
            'diem_giua_ky.required' => 'Vui lòng nhập điểm giữa kỳ',
            'diem_cuoi_ky.required' => 'Vui lòng nhập điểm cuối kỳ',
        ]);

        $result = $this->aiService->predictGrade(
            $request->diem_chuyen_can,
            $request->diem_giua_ky,
            $request->diem_cuoi_ky,
            $request->so_buoi_nghi,
            $request->so_tin_chi
        );

        if (!$result) {
            return back()->with('error', 'Không thể dự đoán. Vui lòng kiểm tra lại hệ thống AI.');
        }

        // Lưu lịch sử dự đoán
        DuDoanHocTap::create([
            'sinh_vien_id' => $request->sinh_vien_id,
            'mon_hoc_id' => $request->mon_hoc_id,
            'du_doan' => $result['prediction'],
            'do_tin_cay' => $result['confidence'],
        ]);

        $sinhVien = SinhVien::find($request->sinh_vien_id);
        $monHoc = MonHoc::find($request->mon_hoc_id);

        return back()->with([
            'success' => 'Dự đoán thành công và đã lưu vào lịch sử!',
            'prediction' => $result,
            'sinhVien' => $sinhVien,
            'monHoc' => $monHoc
        ]);
    }

    // Danh sách sinh viên để dự đoán
    public function students(Request $request)
    {
        $query = SinhVien::with(['lop.khoa', 'dangKyMonHocs.diem']);

        if ($request->lop_id) {
            $query->where('lop_id', $request->lop_id);
        }

        $sinhViens = $query->orderBy('ma_sinh_vien')->paginate(20);
        $lops = Lop::with('khoa')->orderBy('ten_lop')->get();

        return view('admin.ai.students', compact('sinhViens', 'lops'));
    }

    // Phân tích sinh viên nguy cơ
    public function riskAnalysis()
    {
        // Lấy sinh viên có nhiều môn yếu
        $sinhVienNguyCo = SinhVien::whereHas('dangKyMonHocs.diem', function($query) {
            $query->where('trang_thai', 'Yếu');
        })
        ->withCount(['dangKyMonHocs as so_mon_yeu' => function($query) {
            $query->whereHas('diem', function($q) {
                $q->where('trang_thai', 'Yếu');
            });
        }])
        ->with(['lop.khoa', 'dangKyMonHocs.diem', 'dangKyMonHocs.monHoc'])
        ->having('so_mon_yeu', '>', 0)
        ->orderBy('so_mon_yeu', 'desc')
        ->paginate(20);

        return view('admin.ai.risk-analysis', compact('sinhVienNguyCo'));
    }

    // Lịch sử dự đoán
    public function history()
    {
        $duDoans = DuDoanHocTap::with(['sinhVien', 'monHoc'])
            ->orderBy('thoi_gian_du_doan', 'desc')
            ->paginate(20);

        return view('admin.ai.history', compact('duDoans'));
    }

    // Lưu kết quả dự đoán
    public function savePrediction(Request $request)
    {
        $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_viens,id',
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'du_doan' => 'required|string',
            'do_tin_cay' => 'required|numeric|min:0|max:100',
        ]);

        DuDoanHocTap::create([
            'sinh_vien_id' => $request->sinh_vien_id,
            'mon_hoc_id' => $request->mon_hoc_id,
            'du_doan' => $request->du_doan,
            'do_tin_cay' => $request->do_tin_cay,
            'thoi_gian_du_doan' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu kết quả dự đoán'
        ]);
    }
}
