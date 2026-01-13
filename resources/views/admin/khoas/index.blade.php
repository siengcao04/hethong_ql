@extends('layouts.admin')

@section('title', 'Danh sách Khoa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Khoa</h2>
    <a href="{{ route('admin.khoas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Khoa
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">STT</th>
                        <th width="15%">Mã Khoa</th>
                        <th width="25%">Tên Khoa</th>
                        <th width="10%">Số Lớp</th>
                        <th width="30%">Mô tả</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($khoas as $index => $khoa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong class="text-primary">{{ $khoa->ma_khoa }}</strong></td>
                        <td>{{ $khoa->ten_khoa }}</td>
                        <td>
                            <span class="badge bg-info">{{ $khoa->lops_count }} lớp</span>
                        </td>
                        <td>{{ $khoa->mo_ta }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.khoas.edit', $khoa) }}" class="btn btn-warning" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.khoas.destroy', $khoa) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa khoa này?')" class="d-inline">
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
                        <td colspan="6" class="text-center text-muted">Chưa có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
