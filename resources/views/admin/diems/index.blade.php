@extends('layouts.admin')

@section('title', 'Quản lý Điểm')

@section('content')
<div class="mb-4">
    <h2>Quản lý Điểm</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Quản lý Điểm</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-funnel"></i> Chọn Môn học và Lớp</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.diems.danh-sach') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mon_hoc_id" class="form-label">Môn học <span class="text-danger">*</span></label>
                            <select class="form-select @error('mon_hoc_id') is-invalid @enderror" 
                                    id="mon_hoc_id" name="mon_hoc_id" required>
                                <option value="">-- Chọn Môn học --</option>
                                @foreach($monHocs as $monHoc)
                                    <option value="{{ $monHoc->id }}" {{ old('mon_hoc_id') == $monHoc->id ? 'selected' : '' }}>
                                        {{ $monHoc->ten_mon }} ({{ $monHoc->so_tin_chi }} TC)
                                    </option>
                                @endforeach
                            </select>
                            @error('mon_hoc_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="lop_id" class="form-label">Lớp <span class="text-danger">*</span></label>
                            <select class="form-select @error('lop_id') is-invalid @enderror" 
                                    id="lop_id" name="lop_id" required>
                                <option value="">-- Chọn Lớp --</option>
                                @foreach($lops as $lop)
                                    <option value="{{ $lop->id }}" {{ old('lop_id') == $lop->id ? 'selected' : '' }}>
                                        {{ $lop->ten_lop }} - {{ $lop->khoa->ten_khoa }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lop_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hoc_ky" class="form-label">Học kỳ <span class="text-danger">*</span></label>
                            <select class="form-select @error('hoc_ky') is-invalid @enderror" 
                                    id="hoc_ky" name="hoc_ky" required>
                                <option value="">-- Chọn Học kỳ --</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('hoc_ky') == $i ? 'selected' : '' }}>Học kỳ {{ $i }}</option>
                                @endfor
                            </select>
                            @error('hoc_ky')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nam_hoc" class="form-label">Năm học <span class="text-danger">*</span></label>
                            <select class="form-select @error('nam_hoc') is-invalid @enderror" 
                                    id="nam_hoc" name="nam_hoc" required>
                                <option value="">-- Chọn Năm học --</option>
                                @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                    <option value="{{ $year }}-{{ $year + 1 }}" 
                                        {{ old('nam_hoc') == $year.'-'.($year+1) ? 'selected' : '' }}>
                                        {{ $year }}-{{ $year + 1 }}
                                    </option>
                                @endfor
                            </select>
                            @error('nam_hoc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-search"></i> Xem danh sách
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Hướng dẫn</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Quy trình nhập điểm:</strong></p>
                <ol class="mb-0">
                    <li>Chọn <strong>Môn học</strong> cần nhập điểm</li>
                    <li>Chọn <strong>Lớp</strong> tương ứng</li>
                    <li>Chọn <strong>Học kỳ</strong> và <strong>Năm học</strong></li>
                    <li>Click <strong>"Xem danh sách"</strong> để hiển thị sinh viên</li>
                    <li>Nhập điểm cho từng sinh viên (điểm chuyên cần, giữa kỳ, cuối kỳ)</li>
                    <li>Hệ thống tự động tính điểm trung bình và trạng thái</li>
                </ol>
                <hr>
                <p class="mb-0 small text-muted">
                    <i class="bi bi-calculator"></i> <strong>Công thức tính điểm:</strong> 
                    Điểm TB = (Chuyên cần × 10% + Giữa kỳ × 30% + Cuối kỳ × 60%)
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
