<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MonHocController extends Controller
{
    public function index()
    {
        $monHocs = MonHoc::latest()->get();
        return view('admin.mon-hocs.index', compact('monHocs'));
    }

    public function create()
    {
        return view('admin.mon-hocs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ma_mon' => 'required|unique:mon_hocs,ma_mon|max:20',
            'ten_mon' => 'required|max:255',
            'so_tin_chi' => 'required|integer|min:1|max:6',
            'mo_ta' => 'nullable',
        ], [
            'ma_mon.required' => 'Vui lòng nhập mã môn',
            'ma_mon.unique' => 'Mã môn đã tồn tại',
            'ten_mon.required' => 'Vui lòng nhập tên môn',
            'so_tin_chi.required' => 'Vui lòng nhập số tín chỉ',
            'so_tin_chi.min' => 'Số tín chỉ tối thiểu là 1',
            'so_tin_chi.max' => 'Số tín chỉ tối đa là 6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        MonHoc::create($request->all());
        return redirect()->route('admin.mon-hocs.index')->with('success', 'Thêm môn học thành công');
    }

    public function edit(MonHoc $monHoc)
    {
        return view('admin.mon-hocs.edit', compact('monHoc'));
    }

    public function update(Request $request, MonHoc $monHoc)
    {
        $validator = Validator::make($request->all(), [
            'ma_mon' => 'required|max:20|unique:mon_hocs,ma_mon,' . $monHoc->id,
            'ten_mon' => 'required|max:255',
            'so_tin_chi' => 'required|integer|min:1|max:6',
            'mo_ta' => 'nullable',
        ], [
            'ma_mon.required' => 'Vui lòng nhập mã môn',
            'ten_mon.required' => 'Vui lòng nhập tên môn',
            'so_tin_chi.required' => 'Vui lòng nhập số tín chỉ',
            'so_tin_chi.min' => 'Số tín chỉ tối thiểu là 1',
            'so_tin_chi.max' => 'Số tín chỉ tối đa là 6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $monHoc->update($request->all());
        return redirect()->route('admin.mon-hocs.index')->with('success', 'Cập nhật môn học thành công');
    }

    public function destroy(MonHoc $monHoc)
    {
        try {
            $monHoc->delete();
            return redirect()->route('admin.mon-hocs.index')->with('success', 'Xóa môn học thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa môn học này vì có dữ liệu liên quan');
        }
    }
}
