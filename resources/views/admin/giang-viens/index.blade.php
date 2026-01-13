@extends('layouts.admin')

@section('title', 'Quản lý Giảng viên')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Quản lý Giảng viên</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Giảng viên</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.giang-viens.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Giảng viên
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh sách Giảng viên ({{ $giangViens->count() }})</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã GV</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Giới tính</th>
                        <th>SĐT</th>
                        <th>Khoa</th>
                        <th>Ngày sinh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($giangViens as $giangVien)
                        <tr>
                            <td>{{ $loop->iteration + ($giangViens->currentPage() - 1) * $giangViens->perPage() }}</td>
                            <td><strong>{{ $giangVien->ma_giang_vien }}</strong></td>
                            <td>{{ $giangVien->ho_ten }}</td>
                            <td>{{ $giangVien->user->email }}</td>
                            <td>
                                @if($giangVien->gioi_tinh == 'Nam')
                                    <span class="badge bg-primary">Nam</span>
                                @elseif($giangVien->gioi_tinh == 'Nữ')
                                    <span class="badge bg-danger">Nữ</span>
                                @else
                                    <span class="badge bg-secondary">Khác</span>
                                @endif
                            </td>
                            <td>{{ $giangVien->sdt ?? '-' }}</td>
                            <td>
                                <span class="badge bg-success">{{ $giangVien->khoa->ten_khoa }}</span>
                            </td>
                            <td>{{ $giangVien->ngay_sinh ? $giangVien->ngay_sinh->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.giang-viens.edit', $giangVien) }}" 
                                       class="btn btn-warning" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.giang-viens.destroy', $giangVien) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa giảng viên này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Chưa có giảng viên nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($giangViens->hasPages())
        <div class="card-footer">
            {{ $giangViens->links() }}
        </div>
    @endif
</div>
@endsection
