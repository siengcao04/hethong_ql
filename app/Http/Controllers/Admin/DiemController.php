<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonHoc;
use App\Models\Lop;
use App\Models\DangKyMonHoc;
use App\Models\Diem;
use App\Models\SinhVien;
use Illuminate\Support\Facades\DB;

class DiemController extends Controller
{
    // Hiển thị form chọn môn học và lớp
    public function index()
    {
        $monHocs = MonHoc::orderBy('ten_mon')->get();
        $lops = Lop::with('khoa')->orderBy('ten_lop')->get();
        
        return view('admin.diems.index', compact('monHocs', 'lops'));
    }

    // Hiển thị danh sách sinh viên đăng ký môn học
    public function danhSach(Request $request)
    {
        $request->validate([
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'lop_id' => 'required|exists:lops,id',
            'hoc_ky' => 'required|integer|min:1|max:8',
            'nam_hoc' => 'required|string',
        ], [
            'mon_hoc_id.required' => 'Vui lòng chọn môn học',
            'lop_id.required' => 'Vui lòng chọn lớp',
            'hoc_ky.required' => 'Vui lòng nhập học kỳ',
            'nam_hoc.required' => 'Vui lòng nhập năm học',
        ]);

        $monHoc = MonHoc::findOrFail($request->mon_hoc_id);
        $lop = Lop::with('khoa')->findOrFail($request->lop_id);
        $hocKy = $request->hoc_ky;
        $namHoc = $request->nam_hoc;

        // Lấy danh sách sinh viên trong lớp với đăng ký môn học và điểm
        $sinhViens = SinhVien::where('lop_id', $lop->id)
            ->with(['dangKyMonHocs' => function($query) use ($monHoc, $hocKy, $namHoc) {
                $query->where('mon_hoc_id', $monHoc->id)
                      ->where('hoc_ky', $hocKy)
                      ->where('nam_hoc', $namHoc)
                      ->with('diem');
            }])
            ->orderBy('ma_sinh_vien')
            ->get();

        return view('admin.diems.danh-sach', compact('sinhViens', 'monHoc', 'lop', 'hocKy', 'namHoc'));
    }

    // Lưu hoặc cập nhật điểm
    public function store(Request $request)
    {
        $request->validate([
            'sinh_vien_id' => 'required|exists:sinh_viens,id',
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'hoc_ky' => 'required|integer|min:1|max:8',
            'nam_hoc' => 'required|string',
            'diem_chuyen_can' => 'nullable|numeric|min:0|max:10',
            'diem_giua_ky' => 'nullable|numeric|min:0|max:10',
            'diem_cuoi_ky' => 'nullable|numeric|min:0|max:10',
            'so_buoi_nghi' => 'nullable|integer|min:0',
        ], [
            'sinh_vien_id.required' => 'Sinh viên không hợp lệ',
            'mon_hoc_id.required' => 'Môn học không hợp lệ',
            'diem_chuyen_can.numeric' => 'Điểm chuyên cần phải là số',
            'diem_chuyen_can.max' => 'Điểm chuyên cần tối đa 10',
            'diem_giua_ky.numeric' => 'Điểm giữa kỳ phải là số',
            'diem_giua_ky.max' => 'Điểm giữa kỳ tối đa 10',
            'diem_cuoi_ky.numeric' => 'Điểm cuối kỳ phải là số',
            'diem_cuoi_ky.max' => 'Điểm cuối kỳ tối đa 10',
            'so_buoi_nghi.integer' => 'Số buổi nghỉ phải là số nguyên',
        ]);

        DB::beginTransaction();
        try {
            // Kiểm tra hoặc tạo đăng ký môn học
            $dangKyMonHoc = DangKyMonHoc::firstOrCreate(
                [
                    'sinh_vien_id' => $request->sinh_vien_id,
                    'mon_hoc_id' => $request->mon_hoc_id,
                    'hoc_ky' => $request->hoc_ky,
                    'nam_hoc' => $request->nam_hoc,
                ],
                [
                    'giang_vien_id' => null, // Có thể thêm logic gán giảng viên
                ]
            );

            // Cập nhật hoặc tạo điểm
            $diem = Diem::updateOrCreate(
                ['dang_ky_mon_hoc_id' => $dangKyMonHoc->id],
                [
                    'diem_chuyen_can' => $request->diem_chuyen_can,
                    'diem_giua_ky' => $request->diem_giua_ky,
                    'diem_cuoi_ky' => $request->diem_cuoi_ky,
                    'so_buoi_nghi' => $request->so_buoi_nghi ?? 0,
                    // diem_trung_binh và trang_thai được tính tự động trong model
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lưu điểm thành công',
                'diem' => [
                    'diem_trung_binh' => $diem->diem_trung_binh,
                    'trang_thai' => $diem->trang_thai,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
