<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lop;
use App\Models\Khoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LopController extends Controller
{
    public function index()
    {
        $lops = Lop::with('khoa')->withCount('sinhViens')->latest()->get();
        return view('admin.lops.index', compact('lops'));
    }

    public function create()
    {
        $khoas = Khoa::all();
        return view('admin.lops.create', compact('khoas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ma_lop' => 'required|unique:lops,ma_lop|max:20',
            'ten_lop' => 'required|max:255',
            'khoa_id' => 'required|exists:khoas,id',
            'khoa_hoc' => 'required|max:50',
        ], [
            'ma_lop.required' => 'Vui lòng nhập mã lớp',
            'ma_lop.unique' => 'Mã lớp đã tồn tại',
            'ten_lop.required' => 'Vui lòng nhập tên lớp',
            'khoa_id.required' => 'Vui lòng chọn khoa',
            'khoa_hoc.required' => 'Vui lòng nhập khóa học',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Lop::create($request->all());
        return redirect()->route('admin.lops.index')->with('success', 'Thêm lớp thành công');
    }

    public function edit(Lop $lop)
    {
        $khoas = Khoa::all();
        return view('admin.lops.edit', compact('lop', 'khoas'));
    }

    public function update(Request $request, Lop $lop)
    {
        $validator = Validator::make($request->all(), [
            'ma_lop' => 'required|max:20|unique:lops,ma_lop,' . $lop->id,
            'ten_lop' => 'required|max:255',
            'khoa_id' => 'required|exists:khoas,id',
            'khoa_hoc' => 'required|max:50',
        ], [
            'ma_lop.required' => 'Vui lòng nhập mã lớp',
            'ten_lop.required' => 'Vui lòng nhập tên lớp',
            'khoa_id.required' => 'Vui lòng chọn khoa',
            'khoa_hoc.required' => 'Vui lòng nhập khóa học',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $lop->update($request->all());
        return redirect()->route('admin.lops.index')->with('success', 'Cập nhật lớp thành công');
    }

    public function destroy(Lop $lop)
    {
        try {
            $lop->delete();
            return redirect()->route('admin.lops.index')->with('success', 'Xóa lớp thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa lớp này vì có dữ liệu liên quan');
        }
    }
}
