@extends('layouts.admin')

@section('title', 'Sửa Khoa')

@section('content')
<div class="mb-4">
    <h2>Sửa Khoa</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.khoas.index') }}">Khoa</a></li>
            <li class="breadcrumb-item active">Sửa</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin Khoa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.khoas.update', $khoa) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="ma_khoa" class="form-label">Mã Khoa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ma_khoa') is-invalid @enderror" 
                               id="ma_khoa" name="ma_khoa" value="{{ old('ma_khoa', $khoa->ma_khoa) }}" required>
                        @error('ma_khoa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ten_khoa" class="form-label">Tên Khoa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_khoa') is-invalid @enderror" 
                               id="ten_khoa" name="ten_khoa" value="{{ old('ten_khoa', $khoa->ten_khoa) }}" required>
                        @error('ten_khoa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" name="mo_ta" rows="4">{{ old('mo_ta', $khoa->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('admin.khoas.index') }}" class="btn btn-secondary">
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
                <p><strong>Số lớp:</strong> {{ $khoa->lops()->count() }} lớp</p>
                <p><strong>Ngày tạo:</strong> {{ $khoa->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Cập nhật:</strong> {{ $khoa->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
