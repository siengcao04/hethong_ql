@extends('layouts.admin')

@section('title', 'Danh sách sinh viên - Dự đoán AI')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3"><i class="bi bi-people-fill"></i> Danh sách sinh viên</h2>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.ai.students') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Lọc theo lớp</label>
                    <select name="lop_id" class="form-select">
                        <option value="">Tất cả lớp</option>
                        @foreach($lops as $lop)
                            <option value="{{ $lop->id }}" {{ request('lop_id') == $lop->id ? 'selected' : '' }}>
                                {{ $lop->ten_lop }} ({{ $lop->khoa->ten_khoa }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <a href="{{ route('admin.ai.students') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách sinh viên ({{ $sinhViens->total() }})</h5>
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
                            <th>Số môn đã học</th>
                            <th>Điểm TB</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sinhViens as $sv)
                            @php
                                $diems = $sv->dangKyMonHocs->pluck('diem')->filter();
                                $soMonDaHoc = $diems->count();
                                $dtb = $diems->avg('diem_trung_binh');
                                $badgeClass = 'bg-danger';
                                if($dtb) {
                                    if($dtb >= 8) {
                                        $badgeClass = 'bg-success';
                                    } elseif($dtb >= 6.5) {
                                        $badgeClass = 'bg-info';
                                    } elseif($dtb >= 5) {
                                        $badgeClass = 'bg-warning';
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ ($sinhViens->currentPage() - 1) * $sinhViens->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $sv->ma_sinh_vien }}</strong></td>
                                <td>{{ $sv->ho_ten }}</td>
                                <td>{{ $sv->lop->ten_lop }}</td>
                                <td>{{ $sv->lop->khoa->ten_khoa }}</td>
                                <td>{{ $soMonDaHoc }}</td>
                                <td>
                                    @if($dtb)
                                        <span class="badge {{ $badgeClass }}">
                                            {{ number_format($dtb, 2) }}
                                        </span>
                                    @else
                                        <span class="text-muted">Chưa có</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sinh-viens.show', $sv->id) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p>Không có sinh viên nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sinhViens->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
