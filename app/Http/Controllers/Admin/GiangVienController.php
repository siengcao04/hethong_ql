<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiangVien;
use App\Models\Khoa;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GiangVienController extends Controller
{
    public function index()
    {
        $giangViens = GiangVien::with(['khoa', 'user'])->latest()->paginate(15);
        return view('admin.giang-viens.index', compact('giangViens'));
    }

    public function create()
    {
        $khoas = Khoa::all();
        return view('admin.giang-viens.create', compact('khoas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ma_giang_vien' => 'required|unique:giang_viens,ma_giang_vien|max:20',
            'ho_ten' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'sdt' => 'nullable|max:15',
            'dia_chi' => 'nullable',
            'khoa_id' => 'nullable|exists:khoas,id',
        ], [
            'ma_giang_vien.required' => 'Vui lòng nhập mã giảng viên',
            'ma_giang_vien.unique' => 'Mã giảng viên đã tồn tại',
            'ho_ten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại',
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
                'password' => Hash::make('123456'),
                'role_id' => Role::where('name', 'giang-vien')->first()->id,
            ]);

            // Tạo Giảng viên
            GiangVien::create([
                'user_id' => $user->id,
                'ma_giang_vien' => $request->ma_giang_vien,
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'gioi_tinh' => $request->gioi_tinh,
                'sdt' => $request->sdt,
                'dia_chi' => $request->dia_chi,
                'khoa_id' => $request->khoa_id,
            ]);

            DB::commit();
            return redirect()->route('admin.giang-viens.index')->with('success', 'Thêm giảng viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(GiangVien $giangVien)
    {
        $khoas = Khoa::all();
        return view('admin.giang-viens.edit', compact('giangVien', 'khoas'));
    }

    public function update(Request $request, GiangVien $giangVien)
    {
        $validator = Validator::make($request->all(), [
            'ma_giang_vien' => 'required|max:20|unique:giang_viens,ma_giang_vien,' . $giangVien->id,
            'ho_ten' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $giangVien->user_id,
            'ngay_sinh' => 'nullable|date',
            'gioi_tinh' => 'required|in:Nam,Nữ,Khác',
            'sdt' => 'nullable|max:15',
            'dia_chi' => 'nullable',
            'khoa_id' => 'nullable|exists:khoas,id',
        ], [
            'ma_giang_vien.required' => 'Vui lòng nhập mã giảng viên',
            'ho_ten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $giangVien->user->update([
                'name' => $request->ho_ten,
                'email' => $request->email,
            ]);

            $giangVien->update([
                'ma_giang_vien' => $request->ma_giang_vien,
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'gioi_tinh' => $request->gioi_tinh,
                'sdt' => $request->sdt,
                'dia_chi' => $request->dia_chi,
                'khoa_id' => $request->khoa_id,
            ]);

            DB::commit();
            return redirect()->route('admin.giang-viens.index')->with('success', 'Cập nhật giảng viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(GiangVien $giangVien)
    {
        DB::beginTransaction();
        try {
            $user = $giangVien->user;
            $giangVien->delete();
            $user->delete();
            
            DB::commit();
            return redirect()->route('admin.giang-viens.index')->with('success', 'Xóa giảng viên thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa giảng viên này');
        }
    }
}
