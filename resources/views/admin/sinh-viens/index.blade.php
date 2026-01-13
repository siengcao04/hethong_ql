@extends('layouts.admin')

@section('title', 'Danh sách Sinh viên')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Sinh viên</h2>
    <a href="{{ route('admin.sinh-viens.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Sinh viên
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="4%">STT</th>
                        <th width="10%">Mã SV</th>
                        <th width="18%">Họ tên</th>
                        <th width="13%">Email</th>
                        <th width="10%">Giới tính</th>
                        <th width="15%">Lớp</th>
                        <th width="12%">Khóa học</th>
                        <th width="10%">SĐT</th>
                        <th width="13%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinhViens as $index => $sv)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong class="text-primary">{{ $sv->ma_sinh_vien }}</strong></td>
                        <td>{{ $sv->ho_ten }}</td>
                        <td>{{ $sv->user->email }}</td>
                        <td>
                            @if($sv->gioi_tinh == 'Nam')
                                <span class="badge bg-primary">Nam</span>
                            @elseif($sv->gioi_tinh == 'Nữ')
                                <span class="badge bg-danger">Nữ</span>
                            @else
                                <span class="badge bg-secondary">Khác</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $sv->lop->ten_lop }}</small>
                        </td>
                        <td>{{ $sv->khoa_hoc }}</td>
                        <td>{{ $sv->sdt ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.sinh-viens.show', $sv) }}" class="btn btn-info" title="Chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.sinh-viens.edit', $sv) }}" class="btn btn-warning" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.sinh-viens.destroy', $sv) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa sinh viên này?')" class="d-inline">
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
                        <td colspan="9" class="text-center text-muted">Chưa có sinh viên nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
