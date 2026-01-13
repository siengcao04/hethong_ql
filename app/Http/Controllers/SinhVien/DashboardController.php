<?php

namespace App\Http\Controllers\SinhVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DangKyMonHoc;
use App\Models\Diem;
use App\Models\DuDoanHocTap;

class DashboardController extends Controller
{
    public function index()
    {
        $sinhVien = Auth::user()->sinhVien;
        
        // Thống kê tổng quan
        $tongMonDangKy = DangKyMonHoc::where('sinh_vien_id', $sinhVien->id)->count();
        
        $tongMonCoDiem = DangKyMonHoc::where('sinh_vien_id', $sinhVien->id)
            ->whereHas('diem')
            ->count();
            
        $diemTrungBinhChung = Diem::whereHas('dangKyMonHoc', function($q) use ($sinhVien) {
                $q->where('sinh_vien_id', $sinhVien->id);
            })
            ->avg('diem_trung_binh');
            
        // Thống kê theo trạng thái
        $thongKeDiem = Diem::whereHas('dangKyMonHoc', function($q) use ($sinhVien) {
                $q->where('sinh_vien_id', $sinhVien->id);
            })
            ->selectRaw('trang_thai, COUNT(*) as total')
            ->groupBy('trang_thai')
            ->get();
            
        // Điểm gần đây
        $diemGanDay = DangKyMonHoc::where('sinh_vien_id', $sinhVien->id)
            ->with(['monHoc', 'diem'])
            ->whereHas('diem')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
            
        // Môn học yếu (cần cải thiện)
        $monHocYeu = DangKyMonHoc::where('sinh_vien_id', $sinhVien->id)
            ->with(['monHoc', 'diem'])
            ->whereHas('diem', function($q) {
                $q->where('trang_thai', 'Yếu');
            })
            ->get();
            
        // Dự đoán gần đây
        $duDoanGanDay = DuDoanHocTap::where('sinh_vien_id', $sinhVien->id)
            ->with(['monHoc'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('sinh-vien.dashboard', compact(
            'sinhVien',
            'tongMonDangKy',
            'tongMonCoDiem',
            'diemTrungBinhChung',
            'thongKeDiem',
            'diemGanDay',
            'monHocYeu',
            'duDoanGanDay'
        ));
    }
}
