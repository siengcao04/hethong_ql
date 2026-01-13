@extends('layouts.admin')

@section('title', 'Thêm Môn học')

@section('content')
<div class="mb-4">
    <h2>Thêm Môn học Mới</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.mon-hocs.index') }}">Môn học</a></li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin Môn học</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.mon-hocs.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_mon" class="form-label">Mã môn <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_mon') is-invalid @enderror" 
                                   id="ma_mon" name="ma_mon" value="{{ old('ma_mon') }}" 
                                   placeholder="VD: IT001" required>
                            @error('ma_mon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="so_tin_chi" class="form-label">Số tín chỉ <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('so_tin_chi') is-invalid @enderror" 
                                   id="so_tin_chi" name="so_tin_chi" value="{{ old('so_tin_chi', 3) }}" 
                                   min="1" max="6" required>
                            @error('so_tin_chi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ten_mon" class="form-label">Tên môn <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_mon') is-invalid @enderror" 
                               id="ten_mon" name="ten_mon" value="{{ old('ten_mon') }}" 
                               placeholder="VD: Lập trình Cơ bản" required>
                        @error('ten_mon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" name="mo_ta" rows="4" 
                                  placeholder="Nhập mô tả về môn học...">{{ old('mo_ta') }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Lưu
                        </button>
                        <a href="{{ route('admin.mon-hocs.index') }}" class="btn btn-secondary">
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
                    <li>Mã môn nên viết tắt và có số</li>
                    <li>Số tín chỉ thường từ 2-4</li>
                    <li>Tên môn nên đầy đủ, có dấu</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
