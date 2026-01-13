@extends('layouts.admin')

@section('title', 'Chi tiết Sinh viên')

@section('content')
<div class="mb-4">
    <h2>Chi tiết Sinh viên</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sinh-viens.index') }}">Sinh viên</a></li>
            <li class="breadcrumb-item active">Chi tiết</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin Sinh viên</h5>
                <a href="{{ route('admin.sinh-viens.edit', $sinhVien) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Sửa
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Mã sinh viên:</strong><br>
                        <span class="text-primary fs-5">{{ $sinhVien->ma_sinh_vien }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Họ tên:</strong><br>
                        <span class="fs-5">{{ $sinhVien->ho_ten }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Email:</strong><br>
                        {{ $sinhVien->user->email }}
                    </div>
                    <div class="col-md-6">
                        <strong>Số điện thoại:</strong><br>
                        {{ $sinhVien->sdt ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Ngày sinh:</strong><br>
                        {{ $sinhVien->ngay_sinh ? $sinhVien->ngay_sinh->format('d/m/Y') : '-' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Giới tính:</strong><br>
                        @if($sinhVien->gioi_tinh == 'Nam')
                            <span class="badge bg-primary">Nam</span>
                        @elseif($sinhVien->gioi_tinh == 'Nữ')
                            <span class="badge bg-danger">Nữ</span>
                        @else
                            <span class="badge bg-secondary">Khác</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <strong>Khóa học:</strong><br>
                        {{ $sinhVien->khoa_hoc }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Lớp:</strong><br>
                        <span class="badge bg-info">{{ $sinhVien->lop->ten_lop }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Khoa:</strong><br>
                        <span class="badge bg-success">{{ $sinhVien->lop->khoa->ten_khoa }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Địa chỉ:</strong><br>
                    {{ $sinhVien->dia_chi ?? '-' }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kết quả học tập</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Chức năng xem điểm đang được phát triển...</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Thông tin tài khoản</h6>
            </div>
            <div class="card-body">
                <p><strong>Email đăng nhập:</strong><br>{{ $sinhVien->user->email }}</p>
                <p><strong>Vai trò:</strong><br><span class="badge bg-success">Sinh viên</span></p>
                <p class="mb-0"><strong>Trạng thái:</strong><br><span class="badge bg-success">Hoạt động</span></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Thời gian</h6>
            </div>
            <div class="card-body">
                <p><strong>Ngày tạo:</strong><br>{{ $sinhVien->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Cập nhật lần cuối:</strong><br>{{ $sinhVien->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
