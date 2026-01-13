@extends('layouts.admin')

@section('title', 'Thêm Sinh viên')

@section('content')
<div class="mb-4">
    <h2>Thêm Sinh viên Mới</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sinh-viens.index') }}">Sinh viên</a></li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
</div>

<form action="{{ route('admin.sinh-viens.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin cơ bản</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ma_sinh_vien" class="form-label">Mã sinh viên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ma_sinh_vien') is-invalid @enderror" 
                                   id="ma_sinh_vien" name="ma_sinh_vien" value="{{ old('ma_sinh_vien') }}" 
                                   placeholder="VD: SV001" required>
                            @error('ma_sinh_vien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ho_ten" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                   id="ho_ten" name="ho_ten" value="{{ old('ho_ten') }}" 
                                   placeholder="VD: Nguyễn Văn A" required>
                            @error('ho_ten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="VD: nguyenvana@email.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Email sẽ là tài khoản đăng nhập, mật khẩu mặc định: 123456</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" 
                                   id="sdt" name="sdt" value="{{ old('sdt') }}" placeholder="VD: 0123456789">
                            @error('sdt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control @error('ngay_sinh') is-invalid @enderror" 
                                   id="ngay_sinh" name="ngay_sinh" value="{{ old('ngay_sinh') }}">
                            @error('ngay_sinh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="gioi_tinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <select class="form-select @error('gioi_tinh') is-invalid @enderror" 
                                    id="gioi_tinh" name="gioi_tinh" required>
                                <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option value="Khác" {{ old('gioi_tinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gioi_tinh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="khoa_hoc" class="form-label">Khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('khoa_hoc') is-invalid @enderror" 
                                   id="khoa_hoc" name="khoa_hoc" value="{{ old('khoa_hoc', '2020-2024') }}" 
                                   placeholder="VD: 2020-2024" required>
                            @error('khoa_hoc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lop_id" class="form-label">Lớp <span class="text-danger">*</span></label>
                        <select class="form-select @error('lop_id') is-invalid @enderror" 
                                id="lop_id" name="lop_id" required>
                            <option value="">-- Chọn Lớp --</option>
                            @foreach($lops as $lop)
                                <option value="{{ $lop->id }}" {{ old('lop_id') == $lop->id ? 'selected' : '' }}>
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
                                  id="dia_chi" name="dia_chi" rows="3" 
                                  placeholder="Nhập địa chỉ...">{{ old('dia_chi') }}</textarea>
                        @error('dia_chi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-info-circle"></i> Hướng dẫn</h6>
                    <ul class="small mb-0">
                        <li>Mã sinh viên phải duy nhất</li>
                        <li>Email sẽ dùng để đăng nhập</li>
                        <li>Mật khẩu mặc định: <strong>123456</strong></li>
                        <li>Sinh viên có thể đổi mật khẩu sau khi đăng nhập</li>
                    </ul>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save"></i> Lưu
                </button>
                <a href="{{ route('admin.sinh-viens.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
