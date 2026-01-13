@extends('layouts.sinh-vien')

@section('title', 'Xem điểm')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Bảng điểm</h2>
    </div>
</div>

<!-- Bộ lọc -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Lọc kết quả</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('sinh-vien.diems.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Học kỳ</label>
                    <select name="hoc_ky" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('hoc_ky') == '1' ? 'selected' : '' }}>Học kỳ 1</option>
                        <option value="2" {{ request('hoc_ky') == '2' ? 'selected' : '' }}>Học kỳ 2</option>
                        <option value="3" {{ request('hoc_ky') == '3' ? 'selected' : '' }}>Học kỳ 3</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Năm học</label>
                    <select name="nam_hoc" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="2021-2022" {{ request('nam_hoc') == '2021-2022' ? 'selected' : '' }}>2021-2022</option>
                        <option value="2022-2023" {{ request('nam_hoc') == '2022-2023' ? 'selected' : '' }}>2022-2023</option>
                        <option value="2023-2024" {{ request('nam_hoc') == '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="trang_thai" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="Giỏi" {{ request('trang_thai') == 'Giỏi' ? 'selected' : '' }}>Giỏi</option>
                        <option value="Khá" {{ request('trang_thai') == 'Khá' ? 'selected' : '' }}>Khá</option>
                        <option value="Trung bình" {{ request('trang_thai') == 'Trung bình' ? 'selected' : '' }}>Trung bình</option>
                        <option value="Yếu" {{ request('trang_thai') == 'Yếu' ? 'selected' : '' }}>Yếu</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Lọc
                        </button>
                        <a href="{{ route('sinh-vien.diems.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bảng điểm -->
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-table"></i> Chi tiết điểm ({{ $dangKyMonHocs->total() }} môn)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Môn học</th>
                        <th>Giảng viên</th>
                        <th class="text-center">Tín chỉ</th>
                        <th class="text-center">Học kỳ</th>
                        <th class="text-center">CC</th>
                        <th class="text-center">GK</th>
                        <th class="text-center">CK</th>
                        <th class="text-center">Nghỉ</th>
                        <th class="text-center">DTB</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dangKyMonHocs as $dk)
                        <tr>
                            <td>
                                <strong>{{ $dk->monHoc->ma_mon }}</strong><br>
                                <small class="text-muted">{{ $dk->monHoc->ten_mon }}</small>
                            </td>
                            <td>
                                @if($dk->giangVien)
                                    <small>{{ $dk->giangVien->user->name }}</small>
                                @else
                                    <small class="text-muted">Chưa phân công</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $dk->monHoc->so_tin_chi }}</span>
                            </td>
                            <td class="text-center">
                                <small>HK{{ $dk->hoc_ky }}<br>{{ $dk->nam_hoc }}</small>
                            </td>
                            @if($dk->diem)
                                <td class="text-center">{{ $dk->diem->diem_chuyen_can }}</td>
                                <td class="text-center">{{ $dk->diem->diem_giua_ky }}</td>
                                <td class="text-center">{{ $dk->diem->diem_cuoi_ky }}</td>
                                <td class="text-center">
                                    @if($dk->diem->so_buoi_nghi > 0)
                                        <span class="badge bg-warning">{{ $dk->diem->so_buoi_nghi }}</span>
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <strong class="text-primary">{{ number_format($dk->diem->diem_trung_binh, 2) }}</strong>
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
                            @else
                                <td colspan="5" class="text-center text-muted">
                                    <i class="bi bi-hourglass-split"></i> Chưa có điểm
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Không tìm thấy dữ liệu
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $dangKyMonHocs->links() }}
        </div>
    </div>
</div>

<!-- Thống kê tóm tắt -->
@if($dangKyMonHocs->total() > 0)
<div class="row g-4 mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-calculator"></i> Thống kê tóm tắt</h5>
            </div>
            <div class="card-body">
                @php
                    $diemCoKetQua = $dangKyMonHocs->filter(function($dk) {
                        return $dk->diem !== null;
                    });
                    $tongTinChi = $diemCoKetQua->sum(function($dk) {
                        return $dk->monHoc->so_tin_chi;
                    });
                    $diemTichLuy = $diemCoKetQua->sum(function($dk) {
                        return $dk->diem->diem_trung_binh * $dk->monHoc->so_tin_chi;
                    });
                    $gpa = $tongTinChi > 0 ? $diemTichLuy / $tongTinChi : 0;
                @endphp
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Tổng môn đã học</h6>
                            <h3 class="text-primary">{{ $diemCoKetQua->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Tổng tín chỉ</h6>
                            <h3 class="text-success">{{ $tongTinChi }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">GPA (Điểm TB tích lũy)</h6>
                            <h3 class="text-info">{{ number_format($gpa, 2) }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h6 class="text-muted">Xếp loại</h6>
                            <h3 class="
                                @if($gpa >= 8) text-success
                                @elseif($gpa >= 6.5) text-info
                                @elseif($gpa >= 5) text-warning
                                @else text-danger
                                @endif">
                                @if($gpa >= 8) Giỏi
                                @elseif($gpa >= 6.5) Khá
                                @elseif($gpa >= 5) Trung bình
                                @elseif($gpa > 0) Yếu
                                @else Chưa có
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
