@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Dashboard</h1>
    <div class="text-muted">
        <i class="bi bi-calendar"></i> {{ date('d/m/Y H:i') }}
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Thống kê tổng quan -->
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tổng Sinh viên</h6>
                        <h3 class="mb-0 mt-2">{{ $tongSinhVien }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-person fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.sinh-viens.index') }}" class="text-white small">
                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tổng Giảng viên</h6>
                        <h3 class="mb-0 mt-2">{{ $tongGiangVien }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-person-badge fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.giang-viens.index') }}" class="text-white small">
                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tổng Môn học</h6>
                        <h3 class="mb-0 mt-2">{{ $tongMonHoc }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-book fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.mon-hocs.index') }}" class="text-white small">
                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tổng Lớp học</h6>
                        <h3 class="mb-0 mt-2">{{ $tongLop }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.lops.index') }}" class="text-white small">
                    Xem chi tiết <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Biểu đồ phân bố điểm -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Phân bố kết quả học tập</h5>
            </div>
            <div class="card-body">
                <canvas id="diemChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ sinh viên theo khoa -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Sinh viên theo khoa</h5>
            </div>
            <div class="card-body">
                <canvas id="khoaChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sinh viên nguy cơ -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Sinh viên nguy cơ</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Mã SV</th>
                                <th>Họ tên</th>
                                <th>Lớp</th>
                                <th class="text-center">Số môn yếu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sinhVienNguyCo as $sv)
                                <tr>
                                    <td><strong>{{ $sv->ma_sinh_vien }}</strong></td>
                                    <td>{{ $sv->ho_ten }}</td>
                                    <td>{{ $sv->lop->ten_lop }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $sv->so_mon_yeu }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="bi bi-check-circle text-success"></i> Không có sinh viên nguy cơ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.ai.risk-analysis') }}" class="btn btn-sm btn-danger">
                    Xem tất cả <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Môn học khó -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-graph-down"></i> Môn học khó</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Mã môn</th>
                                <th>Tên môn</th>
                                <th class="text-center">Tỷ lệ yếu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monHocKho as $mon)
                                <tr>
                                    <td><strong>{{ $mon->ma_mon }}</strong></td>
                                    <td>{{ $mon->ten_mon }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning">{{ number_format($mon->ty_le_yeu, 1) }}%</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Chưa có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Biểu đồ phân bố điểm
const diemCtx = document.getElementById('diemChart');
new Chart(diemCtx, {
    type: 'doughnut',
    data: {
        labels: ['Giỏi', 'Khá', 'Trung bình', 'Yếu'],
        datasets: [{
            data: [
                {{ $thongKeDiem->where('trang_thai', 'Giỏi')->first()->total ?? 0 }},
                {{ $thongKeDiem->where('trang_thai', 'Khá')->first()->total ?? 0 }},
                {{ $thongKeDiem->where('trang_thai', 'Trung bình')->first()->total ?? 0 }},
                {{ $thongKeDiem->where('trang_thai', 'Yếu')->first()->total ?? 0 }}
            ],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(23, 162, 184, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Biểu đồ sinh viên theo khoa
const khoaCtx = document.getElementById('khoaChart');
new Chart(khoaCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($sinhVienTheoKhoa as $khoa)
                '{{ $khoa->ten_khoa }}',
            @endforeach
        ],
        datasets: [{
            label: 'Số sinh viên',
            data: [
                @foreach($sinhVienTheoKhoa as $khoa)
                    {{ $khoa->sinh_viens_count }},
                @endforeach
            ],
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(118, 75, 162, 0.8)',
                'rgba(255, 193, 7, 0.8)'
            ],
            borderColor: [
                'rgb(102, 126, 234)',
                'rgb(118, 75, 162)',
                'rgb(255, 193, 7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush
