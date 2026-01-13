<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SinhVien;
use App\Models\GiangVien;
use App\Models\MonHoc;
use App\Models\Lop;
use App\Models\Khoa;
use App\Models\Diem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $tongSinhVien = SinhVien::count();
        $tongGiangVien = GiangVien::count();
        $tongMonHoc = MonHoc::count();
        $tongLop = Lop::count();
        $tongKhoa = Khoa::count();

        // Thống kê điểm theo trạng thái
        $thongKeDiem = Diem::select('trang_thai', DB::raw('count(*) as total'))
            ->groupBy('trang_thai')
            ->get();

        // Thống kê sinh viên theo khoa
        $sinhVienTheoKhoa = Khoa::withCount('sinhViens')->get();

        // Danh sách sinh viên có nguy cơ rớt (điểm yếu nhiều)
        $sinhVienNguyCo = SinhVien::whereHas('dangKyMonHocs.diem', function($query) {
            $query->where('trang_thai', 'Yếu');
        })
        ->withCount(['dangKyMonHocs as so_mon_yeu' => function($query) {
            $query->whereHas('diem', function($q) {
                $q->where('trang_thai', 'Yếu');
            });
        }])
        ->having('so_mon_yeu', '>', 0)
        ->orderBy('so_mon_yeu', 'desc')
        ->limit(10)
        ->get();

        // Thống kê môn học có tỷ lệ rớt cao
        $monHocKho = MonHoc::withCount(['dangKyMonHocs as so_sinh_vien'])
            ->withCount(['dangKyMonHocs as so_sinh_vien_yeu' => function($query) {
                $query->whereHas('diem', function($q) {
                    $q->where('trang_thai', 'Yếu');
                });
            }])
            ->having('so_sinh_vien', '>', 0)
            ->get()
            ->map(function($monHoc) {
                $monHoc->ty_le_yeu = $monHoc->so_sinh_vien > 0 
                    ? round(($monHoc->so_sinh_vien_yeu / $monHoc->so_sinh_vien) * 100, 1)
                    : 0;
                return $monHoc;
            })
            ->sortByDesc('ty_le_yeu')
            ->take(5);

        return view('admin.dashboard', compact(
            'tongSinhVien',
            'tongGiangVien',
            'tongMonHoc',
            'tongLop',
            'tongKhoa',
            'thongKeDiem',
            'sinhVienTheoKhoa',
            'sinhVienNguyCo',
            'monHocKho'
        ));
    }
}
