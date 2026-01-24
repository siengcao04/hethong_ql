<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SinhVien;
use App\Models\Lop;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SinhVienController extends Controller
{
    public function index()
    {
        $sinhViens = SinhVien::with(['lop.khoa', 'user'])->latest()->get();
        return view('admin.sinh-viens.index', compact('sinhViens'));
    }

    public function create()
    {
        $lops = Lop::with('khoa')->get();
        return view('admin.sinh-viens.create', compact('lops'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ma_sinh_vien' => 'required|unique:sinh_viens,ma_sinh_vien|max:20',
            'ho_ten' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'sdt' => 'nullable|max:15',
            'dia_chi' => 'nullable',
            'lop_id' => 'required|exists:lops,id',
            'khoa_hoc' => 'required|max:50',
        ], [
            'ma_sinh_vien.required' => 'Vui lòng nhập mã sinh viên',
            'ma_sinh_vien.unique' => 'Mã sinh viên đã tồn tại',
            'ho_ten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại',
            'lop_id.required' => 'Vui lòng chọn lớp',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Tạo User account
            $user = User::create([
                'name' => $request->ho_ten,
                'email' => $request->email,
                'password' => Hash::make('123456'), // Mật khẩu mặc định
                'role_id' => Role::where('name', 'sinh-vien')->first()->id,
            ]);

            // Tạo Sinh viên
            SinhVien::create([
                'user_id' => $user->id,
                'ma_sinh_vien' => $request->ma_sinh_vien,
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'gioi_tinh' => $request->gioi_tinh,
                'sdt' => $request->sdt,
                'dia_chi' => $request->dia_chi,
                'lop_id' => $request->lop_id,
                'khoa_hoc' => $request->khoa_hoc,
            ]);

            DB::commit();
            return redirect()->route('admin.sinh-viens.index')->with('success', 'Thêm sinh viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function show(SinhVien $sinhVien)
    {
        $sinhVien->load(['lop.khoa', 'user', 'dangKyMonHocs.monHoc', 'dangKyMonHocs.diem', 'dangKyMonHocs.giangVien.user']);
        
        // Thống kê điểm
        $diems = $sinhVien->dangKyMonHocs->pluck('diem')->filter();
        $tongMonDangKy = $sinhVien->dangKyMonHocs->count();
        $tongMonCoDiem = $diems->count();
        $diemTrungBinh = $diems->avg('diem_trung_binh');
        
        // Thống kê theo trạng thái
        $thongKe = $diems->groupBy('trang_thai')->map->count();
        
        return view('admin.sinh-viens.show', compact('sinhVien', 'tongMonDangKy', 'tongMonCoDiem', 'diemTrungBinh', 'thongKe'));
    }

    public function edit(SinhVien $sinhVien)
    {
        $lops = Lop::with('khoa')->get();
        return view('admin.sinh-viens.edit', compact('sinhVien', 'lops'));
    }

    public function update(Request $request, SinhVien $sinhVien)
    {
        $validator = Validator::make($request->all(), [
            'ma_sinh_vien' => 'required|max:20|unique:sinh_viens,ma_sinh_vien,' . $sinhVien->id,
            'ho_ten' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $sinhVien->user_id,
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'sdt' => 'nullable|max:15',
            'dia_chi' => 'nullable',
            'lop_id' => 'required|exists:lops,id',
            'khoa_hoc' => 'required|max:50',
        ], [
            'ma_sinh_vien.required' => 'Vui lòng nhập mã sinh viên',
            'ho_ten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'lop_id.required' => 'Vui lòng chọn lớp',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Cập nhật User
            $sinhVien->user->update([
                'name' => $request->ho_ten,
                'email' => $request->email,
            ]);

            // Cập nhật Sinh viên
            $sinhVien->update([
                'ma_sinh_vien' => $request->ma_sinh_vien,
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'gioi_tinh' => $request->gioi_tinh,
                'sdt' => $request->sdt,
                'dia_chi' => $request->dia_chi,
                'lop_id' => $request->lop_id,
                'khoa_hoc' => $request->khoa_hoc,
            ]);

            DB::commit();
            return redirect()->route('admin.sinh-viens.index')->with('success', 'Cập nhật sinh viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(SinhVien $sinhVien)
    {
        DB::beginTransaction();
        try {
            $user = $sinhVien->user;
            $sinhVien->delete();
            $user->delete();
            
            DB::commit();
            return redirect()->route('admin.sinh-viens.index')->with('success', 'Xóa sinh viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa sinh viên này');
        }
    }
}
