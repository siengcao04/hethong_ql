@extends('layouts.admin')

@section('title', 'Thêm Lớp')

@section('content')
<div class="mb-4">
    <h2>Thêm Lớp Mới</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.lops.index') }}">Lớp</a></li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin Lớp</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.lops.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_lop" class="form-label">Mã Lớp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_lop') is-invalid @enderror" 
                                   id="ma_lop" name="ma_lop" value="{{ old('ma_lop') }}" 
                                   placeholder="VD: CNTT01" required>
                            @error('ma_lop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="khoa_id" class="form-label">Khoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('khoa_id') is-invalid @enderror" 
                                    id="khoa_id" name="khoa_id" required>
                                <option value="">-- Chọn Khoa --</option>
                                @foreach($khoas as $khoa)
                                    <option value="{{ $khoa->id }}" {{ old('khoa_id') == $khoa->id ? 'selected' : '' }}>
                                        {{ $khoa->ten_khoa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('khoa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ten_lop" class="form-label">Tên Lớp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_lop') is-invalid @enderror" 
                               id="ten_lop" name="ten_lop" value="{{ old('ten_lop') }}" 
                               placeholder="VD: Công nghệ Thông tin 01" required>
                        @error('ten_lop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="khoa_hoc" class="form-label">Khóa học <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('khoa_hoc') is-invalid @enderror" 
                               id="khoa_hoc" name="khoa_hoc" value="{{ old('khoa_hoc') }}" 
                               placeholder="VD: 2020-2024" required>
                        @error('khoa_hoc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Lưu
                        </button>
                        <a href="{{ route('admin.lops.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Hướng dẫn</h6>
                <ul class="small mb-0">
                    <li>Mã lớp nên bao gồm mã khoa + số thứ tự</li>
                    <li>Chọn khoa trước khi nhập tên lớp</li>
                    <li>Khóa học theo định dạng: năm bắt đầu - năm kết thúc</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
