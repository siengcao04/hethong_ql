<?php

namespace App\Http\Controllers\GiangVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diem;
use App\Models\DangKyMonHoc;
use App\Models\MonHoc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $giangVien = Auth::user()->giangVien;
        
        // Thống kê tổng quan
        $tongMonDayHocKyNay = DangKyMonHoc::where('giang_vien_id', $giangVien->id)
            ->where('nam_hoc', '2021-2022')
            ->where('hoc_ky', 1)
            ->distinct('mon_hoc_id')
            ->count('mon_hoc_id');
            
        $tongSinhVien = DangKyMonHoc::where('giang_vien_id', $giangVien->id)
            ->distinct('sinh_vien_id')
            ->count('sinh_vien_id');
            
        $tongDiemDaNhap = Diem::whereHas('dangKyMonHoc', function($q) use ($giangVien) {
            $q->where('giang_vien_id', $giangVien->id);
        })->count();
        
        $tongDiemChuaNhap = DangKyMonHoc::where('giang_vien_id', $giangVien->id)
            ->doesntHave('diem')
            ->count();

        // Thống kê điểm theo môn học
        $thongKeTheoMon = DangKyMonHoc::where('giang_vien_id', $giangVien->id)
            ->with(['monHoc', 'diem'])
            ->get()
            ->groupBy('mon_hoc_id')
            ->map(function($group) {
                $monHoc = $group->first()->monHoc;
                $tongSV = $group->count();
                $daNhap = $group->filter(fn($dk) => $dk->diem)->count();
                
                return [
                    'mon_hoc' => $monHoc,
                    'tong_sv' => $tongSV,
                    'da_nhap' => $daNhap,
                    'chua_nhap' => $tongSV - $daNhap,
                    'ty_le' => $tongSV > 0 ? round(($daNhap / $tongSV) * 100, 1) : 0
                ];
            });

        // Thống kê điểm theo trạng thái
        $thongKeDiem = Diem::whereHas('dangKyMonHoc', function($q) use ($giangVien) {
            $q->where('giang_vien_id', $giangVien->id);
        })
        ->select('trang_thai', DB::raw('count(*) as total'))
        ->groupBy('trang_thai')
        ->get();

        // Sinh viên cần quan tâm (có nhiều môn yếu do giảng viên này dạy)
        $sinhVienNguyCo = DangKyMonHoc::where('giang_vien_id', $giangVien->id)
            ->whereHas('diem', function($q) {
                $q->where('trang_thai', 'Yếu');
            })
            ->with(['sinhVien.lop', 'monHoc', 'diem'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('giang-vien.dashboard', compact(
            'giangVien',
            'tongMonDayHocKyNay',
            'tongSinhVien',
            'tongDiemDaNhap',
            'tongDiemChuaNhap',
            'thongKeTheoMon',
            'thongKeDiem',
            'sinhVienNguyCo'
        ));
    }
}
