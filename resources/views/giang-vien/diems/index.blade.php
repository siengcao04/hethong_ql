@extends('layouts.giang-vien')

@section('title', 'Nhập điểm')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Nhập điểm sinh viên</h2>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Chọn môn học và học kỳ</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('giang-vien.diems.danh-sach') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Môn học <span class="text-danger">*</span></label>
                    <select name="mon_hoc_id" class="form-select @error('mon_hoc_id') is-invalid @enderror" required>
                        <option value="">-- Chọn môn học --</option>
                        @foreach($monHocs as $monHoc)
                            <option value="{{ $monHoc->id }}">{{ $monHoc->ma_mon }} - {{ $monHoc->ten_mon }}</option>
                        @endforeach
                    </select>
                    @error('mon_hoc_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Học kỳ <span class="text-danger">*</span></label>
                    <select name="hoc_ky" class="form-select @error('hoc_ky') is-invalid @enderror" required>
                        <option value="">-- Chọn học kỳ --</option>
                        <option value="1">Học kỳ 1</option>
                        <option value="2">Học kỳ 2</option>
                        <option value="3">Học kỳ 3</option>
                    </select>
                    @error('hoc_ky')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Năm học <span class="text-danger">*</span></label>
                    <select name="nam_hoc" class="form-select @error('nam_hoc') is-invalid @enderror" required>
                        <option value="">-- Chọn năm học --</option>
                        <option value="2021-2022">2021-2022</option>
                        <option value="2022-2023">2022-2023</option>
                        <option value="2023-2024">2023-2024</option>
                    </select>
                    @error('nam_hoc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-search"></i> Xem danh sách sinh viên
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
