@extends('layouts.admin')

@section('title', 'Dự đoán kết quả học tập AI')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3"> Dự đoán kết quả học tập bằng AI</h2>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Thông tin mô hình -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"> Thông tin mô hình AI</h5>
                </div>
                <div class="card-body">
                    @if($isModelReady)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> Mô hình đã sẵn sàng
                        </div>
                        
                        @if($modelInfo)
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Thuật toán:</strong> 
                                    <span class="badge bg-info">{{ $modelInfo['algorithm'] ?? 'Decision Tree' }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Độ chính xác:</strong> 
                                    <span class="badge bg-success">{{ number_format(($modelInfo['accuracy'] ?? 0) * 100, 2) }}%</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Số lượng mẫu huấn luyện:</strong> {{ $modelInfo['samples_trained'] ?? 'N/A' }}
                                </li>
                                <li class="mb-2">
                                    <strong>Ngày huấn luyện:</strong> 
                                    <small>{{ $modelInfo['trained_at'] ?? 'N/A' }}</small>
                                </li>
                            </ul>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i> Chưa có mô hình AI
                        </div>
                        <p class="mb-0">Vui lòng chạy lệnh huấn luyện mô hình trước.</p>
                    @endif
                </div>
            </div>

            <!-- Hướng dẫn -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Hướng dẫn</h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li>Nhập điểm chuyên cần (0-10)</li>
                        <li>Nhập điểm giữa kỳ (0-10)</li>
                        <li>Nhập điểm cuối kỳ (0-10)</li>
                        <li>Nhập số buổi nghỉ</li>
                        <li>Chọn số tín chỉ (1-6)</li>
                        <li>Nhấn "Dự đoán" để xem kết quả</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Form dự đoán -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"> Nhập thông tin để dự đoán</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ai.predict') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Chọn sinh viên -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Chọn sinh viên <span class="text-danger">*</span></label>
                                <select name="sinh_vien_id" class="form-select @error('sinh_vien_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn sinh viên --</option>
                                    @foreach($sinhViens as $sv)
                                        <option value="{{ $sv->id }}" {{ old('sinh_vien_id') == $sv->id ? 'selected' : '' }}>
                                            {{ $sv->ma_sinh_vien }} - {{ $sv->user->ho_ten }} ({{ $sv->lop->ten_lop }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('sinh_vien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Chọn môn học -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Chọn môn học <span class="text-danger">*</span></label>
                                <select name="mon_hoc_id" class="form-select @error('mon_hoc_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn môn học --</option>
                                    @foreach($monHocs as $mh)
                                        <option value="{{ $mh->id }}" {{ old('mon_hoc_id') == $mh->id ? 'selected' : '' }}>
                                            {{ $mh->ma_mon }} - {{ $mh->ten_mon }} ({{ $mh->so_tin_chi }} TC)
                                        </option>
                                    @endforeach
                                </select>
                                @error('mon_hoc_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Điểm chuyên cần (0-10) <span class="text-danger">*</span></label>
                                <input type="number" name="diem_chuyen_can" class="form-control @error('diem_chuyen_can') is-invalid @enderror" 
                                    step="0.1" min="0" max="10" value="{{ old('diem_chuyen_can') }}" required>
                                @error('diem_chuyen_can')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Điểm giữa kỳ (0-10) <span class="text-danger">*</span></label>
                                <input type="number" name="diem_giua_ky" class="form-control @error('diem_giua_ky') is-invalid @enderror" 
                                    step="0.1" min="0" max="10" value="{{ old('diem_giua_ky') }}" required>
                                @error('diem_giua_ky')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Điểm cuối kỳ (0-10) <span class="text-danger">*</span></label>
                                <input type="number" name="diem_cuoi_ky" class="form-control @error('diem_cuoi_ky') is-invalid @enderror" 
                                    step="0.1" min="0" max="10" value="{{ old('diem_cuoi_ky') }}" required>
                                @error('diem_cuoi_ky')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số buổi nghỉ <span class="text-danger">*</span></label>
                                <input type="number" name="so_buoi_nghi" class="form-control @error('so_buoi_nghi') is-invalid @enderror" 
                                    min="0" value="{{ old('so_buoi_nghi', 0) }}" required>
                                @error('so_buoi_nghi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số tín chỉ <span class="text-danger">*</span></label>
                                <select name="so_tin_chi" class="form-select @error('so_tin_chi') is-invalid @enderror" required>
                                    <option value="">-- Chọn số tín chỉ --</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('so_tin_chi') == $i ? 'selected' : '' }}>{{ $i }} tín chỉ</option>
                                    @endfor
                                </select>
                                @error('so_tin_chi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" {{ !$isModelReady ? 'disabled' : '' }}>
                                <i class="bi bi-cpu"></i> Dự đoán kết quả
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i> Đặt lại
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kết quả dự đoán -->
            @if(session('prediction'))
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"> Kết quả dự đoán</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $pred = session('prediction');
                            $sinhVien = session('sinhVien');
                            $monHoc = session('monHoc');
                            $statusClass = [
                                'Giỏi' => 'success',
                                'Khá' => 'info',
                                'Trung bình' => 'warning',
                                'Yếu' => 'danger'
                            ];
                            $statusIcon = [
                                'Giỏi' => 'trophy-fill',
                                'Khá' => 'star-fill',
                                'Trung bình' => 'check-circle-fill',
                                'Yếu' => 'exclamation-triangle-fill'
                            ];
                        @endphp

                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            <strong>Dự đoán cho:</strong> {{ $sinhVien->user->ho_ten }} ({{ $sinhVien->ma_sinh_vien }}) - Môn {{ $monHoc->ten_mon }}
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h3 class="mb-3">
                                    Kết quả dự đoán: 
                                    <span class="badge bg-{{ $statusClass[$pred['prediction']] ?? 'secondary' }} fs-4">
                                        <i class="bi bi-{{ $statusIcon[$pred['prediction']] ?? 'question-circle' }}"></i>
                                        {{ $pred['prediction'] }}
                                    </span>
                                </h3>
                                <p class="mb-1">
                                    <strong>Độ tin cậy:</strong> 
                                    <span class="badge bg-primary">{{ number_format($pred['confidence'], 2) }}%</span>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mb-2">Phân bố xác suất:</h6>
                                <div class="progress mb-2" style="height: 25px;">
                                    @foreach($pred['probabilities'] as $label => $prob)
                                        @if($prob > 0)
                                            <div class="progress-bar bg-{{ $statusClass[$label] ?? 'secondary' }}" 
                                                 style="width: {{ $prob }}%" 
                                                 title="{{ $label }}: {{ number_format($prob, 1) }}%">
                                                @if($prob > 10)
                                                    {{ $label }}: {{ number_format($prob, 1) }}%
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($pred['probabilities'] as $label => $prob)
                                        <li>
                                            <span class="badge bg-{{ $statusClass[$label] ?? 'secondary' }}">{{ $label }}</span>
                                            {{ number_format($prob, 2) }}%
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        @if($pred['prediction'] == 'Yếu')
                            <div class="alert alert-danger mt-3 mb-0">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <strong>Cảnh báo:</strong> Sinh viên có nguy cơ rớt môn. Cần tư vấn và hỗ trợ thêm!
                            </div>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('admin.ai.history') }}" class="btn btn-outline-primary">
                                <i class="bi bi-clock-history"></i> Xem lịch sử dự đoán
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
