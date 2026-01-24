@extends('layouts.admin')

@section('title', 'Phân tích sinh viên nguy cơ')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3"> Phân tích sinh viên nguy cơ</h2>
            <p class="text-muted">Danh sách sinh viên có nhiều môn yếu, cần quan tâm và hỗ trợ</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Sinh viên cần can thiệp ({{ $sinhVienNguyCo->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Mã SV</th>
                            <th>Họ tên</th>
                            <th>Lớp</th>
                            <th>Khoa</th>
                            <th class="text-center">Số môn yếu</th>
                            <th>Chi tiết môn yếu</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sinhVienNguyCo as $sv)
                            @php
                                $monYeu = $sv->dangKyMonHocs->filter(function($dk) {
                                    return $dk->diem && $dk->diem->trang_thai == 'Yếu';
                                });
                            @endphp
                            <tr>
                                <td>{{ ($sinhVienNguyCo->currentPage() - 1) * $sinhVienNguyCo->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $sv->ma_sinh_vien }}</strong></td>
                                <td>{{ $sv->ho_ten }}</td>
                                <td>{{ $sv->lop->ten_lop }}</td>
                                <td>{{ $sv->lop->khoa->ten_khoa }}</td>
                                <td class="text-center">
                                    <span class="badge bg-danger fs-6">{{ $sv->so_mon_yeu }}</span>
                                </td>
                                <td>
                                    <ul class="mb-0 list-unstyled">
                                        @foreach($monYeu->take(3) as $dk)
                                            <li class="mb-1">
                                                <span class="badge bg-secondary">{{ $dk->monHoc->ma_mon }}</span>
                                                {{ $dk->monHoc->ten_mon }}
                                                <span class="badge bg-danger">{{ number_format($dk->diem->diem_trung_binh, 2) }}</span>
                                            </li>
                                        @endforeach
                                        @if($monYeu->count() > 3)
                                            <li class="text-muted small">và {{ $monYeu->count() - 3 }} môn khác...</li>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('admin.sinh-viens.show', $sv->id) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-check-circle fs-1 text-success"></i>
                                    <p class="mt-2">Không có sinh viên nguy cơ</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sinhVienNguyCo->links() }}
            </div>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm bg-danger text-white">
                <div class="card-body text-center">
                    <h3 class="display-4 mb-0">{{ $sinhVienNguyCo->count() }}</h3>
                    <p class="mb-0">Sinh viên nguy cơ</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="display-4 mb-0">{{ $sinhVienNguyCo->sum('so_mon_yeu') }}</h3>
                    <p class="mb-0">Tổng môn yếu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="display-4 mb-0">
                        {{ $sinhVienNguyCo->isNotEmpty() ? number_format($sinhVienNguyCo->avg('so_mon_yeu'), 1) : 0 }}
                    </h3>
                    <p class="mb-0">TB môn yếu/SV</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
