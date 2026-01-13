@extends('layouts.admin')

@section('title', 'Sửa Lớp')

@section('content')
<div class="mb-4">
    <h2>Sửa Lớp</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.lops.index') }}">Lớp</a></li>
            <li class="breadcrumb-item active">Sửa</li>
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
                <form action="{{ route('admin.lops.update', $lop) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_lop" class="form-label">Mã Lớp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_lop') is-invalid @enderror" 
                                   id="ma_lop" name="ma_lop" value="{{ old('ma_lop', $lop->ma_lop) }}" required>
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
                                    <option value="{{ $khoa->id }}" 
                                        {{ old('khoa_id', $lop->khoa_id) == $khoa->id ? 'selected' : '' }}>
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
                               id="ten_lop" name="ten_lop" value="{{ old('ten_lop', $lop->ten_lop) }}" required>
                        @error('ten_lop')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="khoa_hoc" class="form-label">Khóa học <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('khoa_hoc') is-invalid @enderror" 
                               id="khoa_hoc" name="khoa_hoc" value="{{ old('khoa_hoc', $lop->khoa_hoc) }}" required>
                        @error('khoa_hoc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Cập nhật
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
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Thông tin chi tiết</h6>
            </div>
            <div class="card-body">
                <p><strong>Sĩ số:</strong> {{ $lop->sinhViens()->count() }} sinh viên</p>
                <p><strong>Ngày tạo:</strong> {{ $lop->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Cập nhật:</strong> {{ $lop->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
