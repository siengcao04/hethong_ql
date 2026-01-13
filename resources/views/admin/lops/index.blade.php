@extends('layouts.admin')

@section('title', 'Danh sách Lớp')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Lớp</h2>
    <a href="{{ route('admin.lops.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Thêm Lớp
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">STT</th>
                        <th width="12%">Mã Lớp</th>
                        <th width="25%">Tên Lớp</th>
                        <th width="18%">Khoa</th>
                        <th width="15%">Khóa học</th>
                        <th width="10%">Sĩ số</th>
                        <th width="15%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lops as $index => $lop)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong class="text-primary">{{ $lop->ma_lop }}</strong></td>
                        <td>{{ $lop->ten_lop }}</td>
                        <td>
                            <span class="badge bg-info">{{ $lop->khoa->ten_khoa }}</span>
                        </td>
                        <td>{{ $lop->khoa_hoc }}</td>
                        <td>
                            <span class="badge bg-success">{{ $lop->sinh_viens_count }} SV</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.lops.edit', $lop) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.lops.destroy', $lop) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa lớp này?')" class="d-inline">
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
                        <td colspan="7" class="text-center text-muted">Chưa có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
