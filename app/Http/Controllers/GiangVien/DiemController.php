<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonHoc;
use App\Models\Lop;
use App\Models\DangKyMonHoc;
use App\Models\Diem;
use Illuminate\Support\Facades\Auth;

class DiemController extends Controller
{
    // Chọn môn học và lớp để nhập điểm
    public function index()
    {
        $giangVien = Auth::user()->giangVien;
        
        // Lấy các môn học mà giảng viên đang dạy
        $monHocs = MonHoc::whereHas('dangKyMonHocs', function($q) use ($giangVien) {
            $q->where('giang_vien_id', $giangVien->id);
        })->distinct()->get();

        return view('giang-vien.diems.index', compact('monHocs'));
    }

    // Danh sách sinh viên để nhập điểm
    public function danhSach(Request $request)
    {
        $request->validate([
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'hoc_ky' => 'required|integer',
            'nam_hoc' => 'required|string',
        ]);

        $giangVien = Auth::user()->giangVien;
        $monHoc = MonHoc::findOrFail($request->mon_hoc_id);
        
        // Lấy danh sách đăng ký môn học
        $dangKyMonHocs = DangKyMonHoc::where('giang_vien_id', $giangVien->id)
            ->where('mon_hoc_id', $request->mon_hoc_id)
            ->where('hoc_ky', $request->hoc_ky)
            ->where('nam_hoc', $request->nam_hoc)
            ->with(['sinhVien.lop', 'diem'])
            ->get();

        if ($dangKyMonHocs->isEmpty()) {
            return back()->with('error', 'Không tìm thấy sinh viên nào đăng ký môn học này.');
        }

        return view('giang-vien.diems.danh-sach', compact(
            'dangKyMonHocs',
            'monHoc',
            'request'
        ));
    }

    // Lưu điểm
    public function store(Request $request)
    {
        $request->validate([
            'dang_ky_mon_hoc_id' => 'required|exists:dang_ky_mon_hocs,id',
            'diem_chuyen_can' => 'required|numeric|min:0|max:10',
            'diem_giua_ky' => 'required|numeric|min:0|max:10',
            'diem_cuoi_ky' => 'required|numeric|min:0|max:10',
            'so_buoi_nghi' => 'required|integer|min:0',
        ]);

        // Kiểm tra quyền
        $dangKyMonHoc = DangKyMonHoc::findOrFail($request->dang_ky_mon_hoc_id);
        if ($dangKyMonHoc->giang_vien_id != Auth::user()->giangVien->id) {
            return response()->json(['error' => 'Không có quyền nhập điểm'], 403);
        }

        // Tạo hoặc cập nhật điểm
        $diem = Diem::updateOrCreate(
            ['dang_ky_mon_hoc_id' => $request->dang_ky_mon_hoc_id],
            [
                'diem_chuyen_can' => $request->diem_chuyen_can,
                'diem_giua_ky' => $request->diem_giua_ky,
                'diem_cuoi_ky' => $request->diem_cuoi_ky,
                'so_buoi_nghi' => $request->so_buoi_nghi,
            ]
        );

        return response()->json([
            'success' => true,
            'diem_trung_binh' => number_format($diem->diem_trung_binh, 2),
            'trang_thai' => $diem->trang_thai,
        ]);
    }
}
