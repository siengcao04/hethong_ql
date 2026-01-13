@extends('layouts.admin')

@section('title', 'Danh sách Môn học')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Môn học</h2>
    <a href="{{ route('admin.mon-hocs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Môn học
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">STT</th>
                        <th width="15%">Mã môn</th>
                        <th width="40%">Tên môn</th>
                        <th width="12%">Số tín chỉ</th>
                        <th width="20%">Mô tả</th>
                        <th width="13%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monHocs as $index => $monHoc)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong class="text-primary">{{ $monHoc->ma_mon }}</strong></td>
                        <td>{{ $monHoc->ten_mon }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ $monHoc->so_tin_chi }} TC</span>
                        </td>
                        <td>{{ Str::limit($monHoc->mo_ta, 50) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.mon-hocs.edit', $monHoc) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.mon-hocs.destroy', $monHoc) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa môn học này?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
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
