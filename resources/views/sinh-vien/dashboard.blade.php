@extends('layouts.sinh-vien')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Dashboard Sinh viên</h1>
    <div class="text-muted">
        <i class="bi bi-calendar"></i> {{ date('d/m/Y H:i') }}
    </div>
</div>

<!-- Thông tin cá nhân -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Thông tin cá nhân</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Mã sinh viên:</th>
                        <td><strong>{{ $sinhVien->ma_sinh_vien }}</strong></td>
                    </tr>
                    <tr>
                        <th>Họ và tên:</th>
                        <td><strong>{{ $sinhVien->ho_ten }}</strong></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $sinhVien->email }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="180">Lớp:</th>
                        <td>{{ $sinhVien->lop->ten_lop }}</td>
                    </tr>
                    <tr>
                        <th>Khoa:</th>
                        <td>{{ $sinhVien->lop->khoa->ten_khoa }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>{{ $sinhVien->so_dien_thoai ?? 'Chưa cập nhật' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Tổng môn đăng ký</h6>
                        <h3 class="mb-0 mt-2">{{ $tongMonDangKy }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-book fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Môn có điểm</h6>
                        <h3 class="mb-0 mt-2">{{ $tongMonCoDiem }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-check-circle fs-1"></i>
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
                        <h6 class="card-title mb-0">Điểm TB chung</h6>
                        <h3 class="mb-0 mt-2">{{ $diemTrungBinhChung ? number_format($diemTrungBinhChung, 2) : '--' }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-star fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-{{ $monHocYeu->count() > 0 ? 'danger' : 'secondary' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Môn yếu</h6>
                        <h3 class="mb-0 mt-2">{{ $monHocYeu->count() }}</h3>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
            @if($monHocYeu->count() > 0)
            <div class="card-footer bg-transparent border-0">
                <small class="text-white">Cần cải thiện!</small>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Biểu đồ phân bố điểm -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Phân bố kết quả học tập</h5>
            </div>
            <div class="card-body">
                @if($thongKeDiem->count() > 0)
                    <canvas id="diemChart" width="400" height="300"></canvas>
                @else
                    <p class="text-center text-muted py-5">Chưa có dữ liệu điểm</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Điểm gần đây -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Điểm cập nhật gần đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Môn học</th>
                                <th class="text-center">DTB</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($diemGanDay as $dk)
                                <tr>
                                    <td>
                                        <strong>{{ $dk->monHoc->ma_mon }}</strong><br>
                                        <small class="text-muted">{{ $dk->monHoc->ten_mon }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            {{ number_format($dk->diem->diem_trung_binh, 2) }}
                                        </span>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Chưa có điểm</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('sinh-vien.diems.index') }}" class="btn btn-sm btn-outline-success">
                        Xem tất cả <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Môn học yếu -->
@if($monHocYeu->count() > 0)
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Môn học cần cải thiện</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Môn học</th>
                                <th>Học kỳ</th>
                                <th class="text-center">CC</th>
                                <th class="text-center">GK</th>
                                <th class="text-center">CK</th>
                                <th class="text-center">DTB</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monHocYeu as $dk)
                                <tr>
                                    <td>
                                        <strong>{{ $dk->monHoc->ma_mon }}</strong><br>
                                        <small class="text-muted">{{ $dk->monHoc->ten_mon }}</small>
                                    </td>
                                    <td>HK{{ $dk->hoc_ky }} - {{ $dk->nam_hoc }}</td>
                                    <td class="text-center">{{ $dk->diem->diem_chuyen_can }}</td>
                                    <td class="text-center">{{ $dk->diem->diem_giua_ky }}</td>
                                    <td class="text-center">{{ $dk->diem->diem_cuoi_ky }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            {{ number_format($dk->diem->diem_trung_binh, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $dk->diem->trang_thai }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Dự đoán AI gần đây -->
@if($duDoanGanDay->count() > 0)
<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-robot"></i> Dự đoán kết quả học tập (AI)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Môn học</th>
                                <th>Dự đoán</th>
                                <th>Độ tin cậy</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($duDoanGanDay as $dd)
                                <tr>
                                    <td>
                                        <strong>{{ $dd->monHoc->ma_mon }}</strong><br>
                                        <small class="text-muted">{{ $dd->monHoc->ten_mon }}</small>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($dd->du_doan == 'Giỏi') bg-success
                                            @elseif($dd->du_doan == 'Khá') bg-info
                                            @elseif($dd->du_doan == 'Trung bình') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ $dd->du_doan }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px; width: 150px;">
                                            <div class="progress-bar bg-success" style="width: {{ $dd->do_tin_cay }}%">
                                                {{ $dd->do_tin_cay }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $dd->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
@if($thongKeDiem->count() > 0)
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
@endif
@endpush
