<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Khoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KhoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $khoas = Khoa::withCount('lops')->latest()->get();
        return view('admin.khoas.index', compact('khoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.khoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ma_khoa' => 'required|unique:khoas,ma_khoa|max:20',
            'ten_khoa' => 'required|max:255',
            'mo_ta' => 'nullable',
        ], [
            'ma_khoa.required' => 'Vui lòng nhập mã khoa',
            'ma_khoa.unique' => 'Mã khoa đã tồn tại',
            'ten_khoa.required' => 'Vui lòng nhập tên khoa',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Khoa::create($request->all());

        return redirect()->route('admin.khoas.index')->with('success', 'Thêm khoa thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Khoa $khoa)
    {
        $khoa->load('lops');
        return view('admin.khoas.show', compact('khoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Khoa $khoa)
    {
        return view('admin.khoas.edit', compact('khoa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Khoa $khoa)
    {
        $validator = Validator::make($request->all(), [
            'ma_khoa' => 'required|max:20|unique:khoas,ma_khoa,' . $khoa->id,
            'ten_khoa' => 'required|max:255',
            'mo_ta' => 'nullable',
        ], [
            'ma_khoa.required' => 'Vui lòng nhập mã khoa',
            'ma_khoa.unique' => 'Mã khoa đã tồn tại',
            'ten_khoa.required' => 'Vui lòng nhập tên khoa',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $khoa->update($request->all());

        return redirect()->route('admin.khoas.index')->with('success', 'Cập nhật khoa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Khoa $khoa)
    {
        try {
            $khoa->delete();
            return redirect()->route('admin.khoas.index')->with('success', 'Xóa khoa thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa khoa này vì có dữ liệu liên quan');
        }
    }
}
