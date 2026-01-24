@extends('layouts.admin')

@section('title', 'Lịch sử dự đoán')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3">Lịch sử dự đoán AI</h2>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Các dự đoán đã lưu ({{ $duDoans->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Thời gian</th>
                            <th>Sinh viên</th>
                            <th>Môn học</th>
                            <th>Dự đoán</th>
                            <th>Độ tin cậy</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($duDoans as $dd)
                            <tr>
                                <td>{{ ($duDoans->currentPage() - 1) * $duDoans->perPage() + $loop->iteration }}</td>
                                <td>{{ $dd->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <strong>{{ $dd->sinhVien->ma_sinh_vien }}</strong><br>
                                    <small>{{ $dd->sinhVien->user->ho_ten }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $dd->monHoc->ma_mon }}</span>
                                    {{ $dd->monHoc->ten_mon }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'Giỏi' => 'success',
                                            'Khá' => 'info',
                                            'Trung bình' => 'warning',
                                            'Yếu' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusClass[$dd->du_doan] ?? 'secondary' }}">
                                        {{ $dd->du_doan }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar 
                                            @if($dd->do_tin_cay >= 80) bg-success
                                            @elseif($dd->do_tin_cay >= 60) bg-info
                                            @elseif($dd->do_tin_cay >= 40) bg-warning
                                            @else bg-danger
                                            @endif" 
                                            style="width: {{ $dd->do_tin_cay }}%">
                                            {{ number_format($dd->do_tin_cay, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p>Chưa có dự đoán nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $duDoans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
