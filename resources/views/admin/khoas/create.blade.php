@extends('layouts.admin')

@section('title', 'Thêm Khoa')

@section('content')
<div class="mb-4">
    <h2>Thêm Khoa Mới</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.khoas.index') }}">Khoa</a></li>
            <li class="breadcrumb-item active">Thêm mới</li>
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
                <form action="{{ route('admin.khoas.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="ma_khoa" class="form-label">Mã Khoa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ma_khoa') is-invalid @enderror" 
                               id="ma_khoa" name="ma_khoa" value="{{ old('ma_khoa') }}" 
                               placeholder="VD: CNTT" required>
                        @error('ma_khoa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ten_khoa" class="form-label">Tên Khoa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_khoa') is-invalid @enderror" 
                               id="ten_khoa" name="ten_khoa" value="{{ old('ten_khoa') }}" 
                               placeholder="VD: Công nghệ Thông tin" required>
                        @error('ten_khoa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" name="mo_ta" rows="4" 
                                  placeholder="Nhập mô tả về khoa...">{{ old('mo_ta') }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Lưu
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
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Hướng dẫn</h6>
                <ul class="small mb-0">
                    <li>Mã khoa nên viết tắt, không dấu</li>
                    <li>Tên khoa nên đầy đủ, có dấu</li>
                    <li>Các trường có dấu <span class="text-danger">*</span> là bắt buộc</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
