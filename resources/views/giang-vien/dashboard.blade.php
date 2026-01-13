@extends('layouts.giang-vien')

@section('title', 'Dashboard Giảng viên')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Dashboard Giảng viên</h1>
    <div class="text-muted">
        <i class="bi bi-calendar"></i> {{ date('d/m/Y H:i') }}
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Thống kê tổng quan -->
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Môn đang dạy</h6>
                        <h3 class="mb-0 mt-2">{{ $tongMonDayHocKyNay }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-book fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tổng sinh viên</h6>
                        <h3 class="mb-0 mt-2">{{ $tongSinhVien }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Điểm đã nhập</h6>
                        <h3 class="mb-0 mt-2">{{ $tongDiemDaNhap }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Điểm chưa nhập</h6>
                        <h3 class="mb-0 mt-2">{{ $tongDiemChuaNhap }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-circle fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('giang-vien.diems.index') }}" class="text-white small">
                    Nhập điểm <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Biểu đồ điểm -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Phân bố kết quả</h5>
            </div>
            <div class="card-body">
                <canvas id="diemChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Tiến độ nhập điểm -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Tiến độ nhập điểm theo môn</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Môn học</th>
                                <th class="text-center">Tổng SV</th>
                                <th class="text-center">Đã nhập</th>
                                <th>Tiến độ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($thongKeTheoMon as $tk)
                                <tr>
                                    <td>
                                        <strong>{{ $tk['mon_hoc']->ma_mon }}</strong><br>
                                        <small class="text-muted">{{ $tk['mon_hoc']->ten_mon }}</small>
                                    </td>
                                    <td class="text-center">{{ $tk['tong_sv'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $tk['da_nhap'] }}</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($tk['ty_le'] >= 80) bg-success
                                                @elseif($tk['ty_le'] >= 50) bg-info
                                                @elseif($tk['ty_le'] >= 20) bg-warning
                                                @else bg-danger
                                                @endif" 
                                                style="width: {{ $tk['ty_le'] }}%">
                                                {{ $tk['ty_le'] }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Chưa có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sinh viên cần quan tâm -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Sinh viên yếu cần quan tâm</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Mã SV</th>
                                <th>Họ tên</th>
                                <th>Lớp</th>
                                <th>Môn học</th>
                                <th>DTB</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sinhVienNguyCo as $dk)
                                <tr>
                                    <td><strong>{{ $dk->sinhVien->ma_sinh_vien }}</strong></td>
                                    <td>{{ $dk->sinhVien->ho_ten }}</td>
                                    <td>{{ $dk->sinhVien->lop->ten_lop }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $dk->monHoc->ma_mon }}</span>
                                        {{ $dk->monHoc->ten_mon }}
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ number_format($dk->diem->diem_trung_binh, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $dk->diem->trang_thai }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <i class="bi bi-check-circle text-success"></i> Không có sinh viên yếu
                                    </td>
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
</script>
@endpush
