@extends('layouts.admin')

@section('title', 'Sửa Giảng viên')

@section('content')
<div class="mb-4">
    <h2>Sửa Giảng viên</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.giang-viens.index') }}">Giảng viên</a></li>
            <li class="breadcrumb-item active">Sửa</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.giang-viens.update', $giangVien) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin Giảng viên</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_giang_vien" class="form-label">Mã giảng viên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_giang_vien') is-invalid @enderror" 
                                   id="ma_giang_vien" name="ma_giang_vien" 
                                   value="{{ old('ma_giang_vien', $giangVien->ma_giang_vien) }}" required>
                            @error('ma_giang_vien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ho_ten" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                   id="ho_ten" name="ho_ten" value="{{ old('ho_ten', $giangVien->ho_ten) }}" required>
                            @error('ho_ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $giangVien->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" 
                                   id="sdt" name="sdt" value="{{ old('sdt', $giangVien->sdt) }}">
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
                                   value="{{ old('ngay_sinh', $giangVien->ngay_sinh ? $giangVien->ngay_sinh->format('Y-m-d') : '') }}">
                            @error('ngay_sinh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="gioi_tinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <select class="form-select @error('gioi_tinh') is-invalid @enderror" 
                                    id="gioi_tinh" name="gioi_tinh" required>
                                <option value="Nam" {{ old('gioi_tinh', $giangVien->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gioi_tinh', $giangVien->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option value="Khác" {{ old('gioi_tinh', $giangVien->gioi_tinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gioi_tinh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="khoa_id" class="form-label">Khoa <span class="text-danger">*</span></label>
                            <select class="form-select @error('khoa_id') is-invalid @enderror" 
                                    id="khoa_id" name="khoa_id" required>
                                <option value="">-- Chọn Khoa --</option>
                                @foreach($khoas as $khoa)
                                    <option value="{{ $khoa->id }}" 
                                        {{ old('khoa_id', $giangVien->khoa_id) == $khoa->id ? 'selected' : '' }}>
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
                        <label for="dia_chi" class="form-label">Địa chỉ</label>
                        <textarea class="form-control @error('dia_chi') is-invalid @enderror" 
                                  id="dia_chi" name="dia_chi" rows="3">{{ old('dia_chi', $giangVien->dia_chi) }}</textarea>
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
                    <p><strong>Ngày tạo:</strong><br>{{ $giangVien->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><strong>Cập nhật:</strong><br>{{ $giangVien->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.giang-viens.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
