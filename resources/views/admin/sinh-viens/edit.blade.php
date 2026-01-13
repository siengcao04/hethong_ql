@extends('layouts.admin')

@section('title', 'Sửa Sinh viên')

@section('content')
<div class="mb-4">
    <h2>Sửa Sinh viên</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sinh-viens.index') }}">Sinh viên</a></li>
            <li class="breadcrumb-item active">Sửa</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.sinh-viens.update', $sinhVien) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Sinh viên</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_sinh_vien" class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_sinh_vien') is-invalid @enderror" 
                                   id="ma_sinh_vien" name="ma_sinh_vien" 
                                   value="{{ old('ma_sinh_vien', $sinhVien->ma_sinh_vien) }}" required>
                            @error('ma_sinh_vien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ho_ten" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                   id="ho_ten" name="ho_ten" value="{{ old('ho_ten', $sinhVien->ho_ten) }}" required>
                            @error('ho_ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $sinhVien->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" 
                                   id="sdt" name="sdt" value="{{ old('sdt', $sinhVien->sdt) }}">
                            @error('sdt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control @error('ngay_sinh') is-invalid @enderror" 
                                   id="ngay_sinh" name="ngay_sinh" 
                                   value="{{ old('ngay_sinh', $sinhVien->ngay_sinh ? $sinhVien->ngay_sinh->format('Y-m-d') : '') }}">
                            @error('ngay_sinh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="gioi_tinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <select class="form-select @error('gioi_tinh') is-invalid @enderror" 
                                    id="gioi_tinh" name="gioi_tinh" required>
                                <option value="Nam" {{ old('gioi_tinh', $sinhVien->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gioi_tinh', $sinhVien->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option value="Khác" {{ old('gioi_tinh', $sinhVien->gioi_tinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gioi_tinh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="khoa_hoc" class="form-label">Khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('khoa_hoc') is-invalid @enderror" 
                                   id="khoa_hoc" name="khoa_hoc" value="{{ old('khoa_hoc', $sinhVien->khoa_hoc) }}" required>
                            @error('khoa_hoc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lop_id" class="form-label">Lớp <span class="text-danger">*</span></label>
                        <select class="form-select @error('lop_id') is-invalid @enderror" id="lop_id" name="lop_id" required>
                            <option value="">-- Chọn Lớp --</option>
                            @foreach($lops as $lop)
                                <option value="{{ $lop->id }}" 
                                    {{ old('lop_id', $sinhVien->lop_id) == $lop->id ? 'selected' : '' }}>
                                    {{ $lop->ten_lop }} - {{ $lop->khoa->ten_khoa }}
                                </option>
                            @endforeach
                        </select>
                        @error('lop_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ</label>
                        <textarea class="form-control @error('dia_chi') is-invalid @enderror" 
                                  id="dia_chi" name="dia_chi" rows="3">{{ old('dia_chi', $sinhVien->dia_chi) }}</textarea>
                        @error('dia_chi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Thông tin chi tiết</h6>
                </div>
                <div class="card-body">
                    <p><strong>Ngày tạo:</strong><br>{{ $sinhVien->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Cập nhật:</strong><br>{{ $sinhVien->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.sinh-viens.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
