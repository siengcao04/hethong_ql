@extends('layouts.admin')

@section('title', 'Sửa Môn học')

@section('content')
<div class="mb-4">
    <h2>Sửa Môn học</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.mon-hocs.index') }}">Môn học</a></li>
            <li class="breadcrumb-item active">Sửa</li>
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
                <form action="{{ route('admin.mon-hocs.update', $monHoc) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_mon" class="form-label">Mã môn <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_mon') is-invalid @enderror" 
                                   id="ma_mon" name="ma_mon" value="{{ old('ma_mon', $monHoc->ma_mon) }}" required>
                            @error('ma_mon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="so_tin_chi" class="form-label">Số tín chỉ <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('so_tin_chi') is-invalid @enderror" 
                                   id="so_tin_chi" name="so_tin_chi" 
                                   value="{{ old('so_tin_chi', $monHoc->so_tin_chi) }}" 
                                   min="1" max="6" required>
                            @error('so_tin_chi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ten_mon" class="form-label">Tên môn <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_mon') is-invalid @enderror" 
                               id="ten_mon" name="ten_mon" value="{{ old('ten_mon', $monHoc->ten_mon) }}" required>
                        @error('ten_mon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" name="mo_ta" rows="4">{{ old('mo_ta', $monHoc->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Cập nhật
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
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Thông tin chi tiết</h6>
            </div>
            <div class="card-body">
                <p><strong>Ngày tạo:</strong> {{ $monHoc->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Cập nhật:</strong> {{ $monHoc->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
