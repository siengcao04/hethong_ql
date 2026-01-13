@extends('layouts.admin')

@section('title', 'Nhập Điểm - ' . $monHoc->ten_mon)

@section('content')
<div class="mb-4">
    <h2>Nhập Điểm - {{ $monHoc->ten_mon }}</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.diems.index') }}">Quản lý Điểm</a></li>
            <li class="breadcrumb-item active">Nhập điểm</li>
        </ol>
    </nav>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Môn học:</strong><br>
                        <span class="badge bg-primary">{{ $monHoc->ten_mon }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Lớp:</strong><br>
                        <span class="badge bg-success">{{ $lop->ten_lop }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Học kỳ:</strong><br>
                        <span class="badge bg-info">HK{{ $hocKy }} - {{ $namHoc }}</span>
                    </div>
                    <div class="col-md-3">
                        <strong>Số sinh viên:</strong><br>
                        <span class="badge bg-warning">{{ $sinhViens->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách Sinh viên</h5>
        <a href="{{ route('admin.diems.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">STT</th>
                        <th width="10%">Mã SV</th>
                        <th width="15%">Họ tên</th>
                        <th width="8%">CC</th>
                        <th width="8%">GK</th>
                        <th width="8%">CK</th>
                        <th width="8%">Nghỉ</th>
                        <th width="10%">ĐTB</th>
                        <th width="10%">Trạng thái</th>
                        <th width="18%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinhViens as $index => $sinhVien)
                        @php
                            $dangKy = $sinhVien->dangKyMonHocs->first();
                            $diem = $dangKy ? $dangKy->diem : null;
                        @endphp
                        <tr id="row-{{ $sinhVien->id }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $sinhVien->ma_sinh_vien }}</strong></td>
                            <td>{{ $sinhVien->ho_ten }}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       id="cc-{{ $sinhVien->id }}" 
                                       value="{{ $diem ? $diem->diem_chuyen_can : '' }}" 
                                       min="0" max="10" step="0.1" placeholder="0-10">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       id="gk-{{ $sinhVien->id }}" 
                                       value="{{ $diem ? $diem->diem_giua_ky : '' }}" 
                                       min="0" max="10" step="0.1" placeholder="0-10">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       id="ck-{{ $sinhVien->id }}" 
                                       value="{{ $diem ? $diem->diem_cuoi_ky : '' }}" 
                                       min="0" max="10" step="0.1" placeholder="0-10">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       id="nghi-{{ $sinhVien->id }}" 
                                       value="{{ $diem ? $diem->so_buoi_nghi : 0 }}" 
                                       min="0" placeholder="0">
                            </td>
                            <td class="text-center">
                                <strong id="dtb-{{ $sinhVien->id }}" class="text-primary">
                                    {{ $diem && $diem->diem_trung_binh ? number_format($diem->diem_trung_binh, 2) : '-' }}
                                </strong>
                            </td>
                            <td class="text-center">
                                <span id="status-{{ $sinhVien->id }}" class="badge 
                                    @if($diem && $diem->trang_thai == 'Giỏi') bg-success
                                    @elseif($diem && $diem->trang_thai == 'Khá') bg-info
                                    @elseif($diem && $diem->trang_thai == 'Trung bình') bg-warning
                                    @elseif($diem && $diem->trang_thai == 'Yếu') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ $diem ? $diem->trang_thai : 'Chưa có' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm btn-save" 
                                        data-id="{{ $sinhVien->id }}"
                                        onclick="saveDiem({{ $sinhVien->id }})">
                                    <i class="bi bi-save"></i> Lưu
                                </button>
                                <span id="saving-{{ $sinhVien->id }}" class="text-muted small" style="display:none;">
                                    <i class="bi bi-hourglass-split"></i> Đang lưu...
                                </span>
                                <span id="saved-{{ $sinhVien->id }}" class="text-success small" style="display:none;">
                                    <i class="bi bi-check-circle"></i> Đã lưu
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Không có sinh viên nào trong lớp này</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .table input.form-control-sm {
        width: 70px;
    }
</style>
@endpush

@push('scripts')
<script>
function saveDiem(sinhVienId) {
    const cc = document.getElementById(`cc-${sinhVienId}`).value;
    const gk = document.getElementById(`gk-${sinhVienId}`).value;
    const ck = document.getElementById(`ck-${sinhVienId}`).value;
    const nghi = document.getElementById(`nghi-${sinhVienId}`).value;

    // Show loading
    document.getElementById(`saving-${sinhVienId}`).style.display = 'inline';
    document.querySelector(`button[data-id="${sinhVienId}"]`).style.display = 'none';
    document.getElementById(`saved-${sinhVienId}`).style.display = 'none';

    fetch('{{ route("admin.diems.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            sinh_vien_id: sinhVienId,
            mon_hoc_id: {{ $monHoc->id }},
            hoc_ky: {{ $hocKy }},
            nam_hoc: '{{ $namHoc }}',
            diem_chuyen_can: cc || null,
            diem_giua_ky: gk || null,
            diem_cuoi_ky: ck || null,
            so_buoi_nghi: nghi || 0
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update điểm trung bình
            document.getElementById(`dtb-${sinhVienId}`).textContent = 
                data.diem.diem_trung_binh ? parseFloat(data.diem.diem_trung_binh).toFixed(2) : '-';
            
            // Update trạng thái
            const statusBadge = document.getElementById(`status-${sinhVienId}`);
            statusBadge.textContent = data.diem.trang_thai || 'Chưa có';
            
            // Update badge color
            statusBadge.className = 'badge ';
            if (data.diem.trang_thai === 'Giỏi') statusBadge.className += 'bg-success';
            else if (data.diem.trang_thai === 'Khá') statusBadge.className += 'bg-info';
            else if (data.diem.trang_thai === 'Trung bình') statusBadge.className += 'bg-warning';
            else if (data.diem.trang_thai === 'Yếu') statusBadge.className += 'bg-danger';
            else statusBadge.className += 'bg-secondary';

            // Show success
            document.getElementById(`saving-${sinhVienId}`).style.display = 'none';
            document.getElementById(`saved-${sinhVienId}`).style.display = 'inline';
            
            setTimeout(() => {
                document.getElementById(`saved-${sinhVienId}`).style.display = 'none';
                document.querySelector(`button[data-id="${sinhVienId}"]`).style.display = 'inline';
            }, 2000);
        } else {
            alert('Lỗi: ' + data.message);
            document.getElementById(`saving-${sinhVienId}`).style.display = 'none';
            document.querySelector(`button[data-id="${sinhVienId}"]`).style.display = 'inline';
        }
    })
    .catch(error => {
        alert('Có lỗi xảy ra: ' + error);
        document.getElementById(`saving-${sinhVienId}`).style.display = 'none';
        document.querySelector(`button[data-id="${sinhVienId}"]`).style.display = 'inline';
    });
}
</script>
@endpush
