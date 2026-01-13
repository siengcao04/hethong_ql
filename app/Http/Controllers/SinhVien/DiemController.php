<?php

namespace App\Http\Controllers\SinhVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DangKyMonHoc;

class DiemController extends Controller
{
    public function index(Request $request)
    {
        $sinhVien = Auth::user()->sinhVien;
        
        $query = DangKyMonHoc::where('sinh_vien_id', $sinhVien->id)
            ->with(['monHoc', 'diem', 'giangVien.user']);
            
        // Lọc theo học kỳ
        if ($request->hoc_ky) {
            $query->where('hoc_ky', $request->hoc_ky);
        }
        
        // Lọc theo năm học
        if ($request->nam_hoc) {
            $query->where('nam_hoc', $request->nam_hoc);
        }
        
        // Lọc theo trạng thái
        if ($request->trang_thai) {
            $query->whereHas('diem', function($q) use ($request) {
                $q->where('trang_thai', $request->trang_thai);
            });
        }
        
        $dangKyMonHocs = $query->orderBy('nam_hoc', 'desc')
            ->orderBy('hoc_ky', 'desc')
            ->paginate(15);
            
        return view('sinh-vien.diems.index', compact('dangKyMonHocs'));
    }
}
