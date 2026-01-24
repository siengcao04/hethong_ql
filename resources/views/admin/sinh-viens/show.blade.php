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

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Tổng quan học tập</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <h3 class="text-primary mb-1">{{ $tongMonDangKy }}</h3>
                            <small class="text-muted">Tổng môn đăng ký</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <h3 class="text-success mb-1">{{ $tongMonCoDiem }}</h3>
                            <small class="text-muted">Môn có điểm</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <h3 class="text-info mb-1">{{ $diemTrungBinh ? number_format($diemTrungBinh, 2) : '--' }}</h3>
                            <small class="text-muted">Điểm TB chung</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            @php
                                $xepLoai = '--';
                                if($diemTrungBinh) {
                                    if($diemTrungBinh >= 8) $xepLoai = 'Giỏi';
                                    elseif($diemTrungBinh >= 6.5) $xepLoai = 'Khá';
                                    elseif($diemTrungBinh >= 5) $xepLoai = 'TB';
                                    else $xepLoai = 'Yếu';
                                }
                            @endphp
                            <h3 class="
                                @if($xepLoai == 'Giỏi') text-success
                                @elseif($xepLoai == 'Khá') text-info
                                @elseif($xepLoai == 'TB') text-warning
                                @elseif($xepLoai == 'Yếu') text-danger
                                @else text-muted
                                @endif mb-1">{{ $xepLoai }}</h3>
                            <small class="text-muted">Xếp loại</small>
                        </div>
                    </div>
                </div>

                @if($thongKe->count() > 0)
                <div class="mt-3">
                    <h6>Phân bố điểm:</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="badge bg-success">Giỏi: {{ $thongKe->get('Giỏi', 0) }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="badge bg-info">Khá: {{ $thongKe->get('Khá', 0) }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="badge bg-warning">Trung bình: {{ $thongKe->get('Trung bình', 0) }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="badge bg-danger">Yếu: {{ $thongKe->get('Yếu', 0) }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-table"></i> Bảng điểm chi tiết</h5>
            </div>
            <div class="card-body">
                @if($sinhVien->dangKyMonHocs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Môn học</th>
                                <th>Giảng viên</th>
                                <th>Học kỳ</th>
                                <th>Năm học</th>
                                <th class="text-center">CC</th>
                                <th class="text-center">GK</th>
                                <th class="text-center">CK</th>
                                <th class="text-center">DTB</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sinhVien->dangKyMonHocs as $dk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $dk->monHoc->ma_mon }}</strong><br>
                                    <small class="text-muted">{{ $dk->monHoc->ten_mon }}</small>
                                </td>
                                <td>
                                    @if($dk->giangVien)
                                        {{ $dk->giangVien->user->name }}
                                    @else
                                        <span class="text-muted">Chưa phân công</span>
                                    @endif
                                </td>
                                <td class="text-center">HK{{ $dk->hoc_ky }}</td>
                                <td class="text-center">{{ $dk->nam_hoc }}</td>
                                @if($dk->diem)
                                    <td class="text-center">{{ $dk->diem->diem_chuyen_can }}</td>
                                    <td class="text-center">{{ $dk->diem->diem_giua_ky }}</td>
                                    <td class="text-center">{{ $dk->diem->diem_cuoi_ky }}</td>
                                    <td class="text-center">
                                        <strong class="text-primary">{{ number_format($dk->diem->diem_trung_binh, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($dk->diem->trang_thai == 'Giỏi') bg-success
                                            @elseif($dk->diem->trang_thai == 'Khá') bg-info
                                            @elseif($dk->diem->trang_thai == 'Trung bình') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ $dk->diem->trang_thai }}
                                        </span>
                                    </td>
                                @else
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="bi bi-hourglass-split"></i> Chưa có điểm
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">Chưa nhập</span>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mt-2">Sinh viên chưa đăng ký môn học nào</p>
                </div>
                @endif
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
