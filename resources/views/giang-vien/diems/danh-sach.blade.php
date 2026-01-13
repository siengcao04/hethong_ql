@extends('layouts.giang-vien')

@section('title', 'Danh sách sinh viên - Nhập điểm')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Nhập điểm: {{ $monHoc->ten_mon }}</h2>
        <p class="text-muted">
            Học kỳ {{ $request->hoc_ky }} - Năm học {{ $request->nam_hoc }} | 
            <strong>{{ $dangKyMonHocs->count() }}</strong> sinh viên
        </p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã SV</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th>CC (10%)</th>
                        <th>GK (30%)</th>
                        <th>CK (60%)</th>
                        <th>Nghỉ</th>
                        <th>DTB</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dangKyMonHocs as $dk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $dk->sinhVien->ma_sinh_vien }}</strong></td>
                            <td>{{ $dk->sinhVien->ho_ten }}</td>
                            <td>{{ $dk->sinhVien->lop->ten_lop }}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                    id="cc_{{ $dk->id }}" 
                                    step="0.1" min="0" max="10"
                                    value="{{ $dk->diem->diem_chuyen_can ?? '' }}" 
                                    style="width: 70px;">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                    id="gk_{{ $dk->id }}" 
                                    step="0.1" min="0" max="10"
                                    value="{{ $dk->diem->diem_giua_ky ?? '' }}" 
                                    style="width: 70px;">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                    id="ck_{{ $dk->id }}" 
                                    step="0.1" min="0" max="10"
                                    value="{{ $dk->diem->diem_cuoi_ky ?? '' }}" 
                                    style="width: 70px;">
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                    id="nghi_{{ $dk->id }}" 
                                    min="0"
                                    value="{{ $dk->diem->so_buoi_nghi ?? 0 }}" 
                                    style="width: 60px;">
                            </td>
                            <td>
                                <span id="dtb_{{ $dk->id }}" class="badge bg-secondary">
                                    {{ $dk->diem ? number_format($dk->diem->diem_trung_binh, 2) : '--' }}
                                </span>
                            </td>
                            <td>
                                <span id="status_{{ $dk->id }}" class="badge 
                                    @if($dk->diem)
                                        @if($dk->diem->trang_thai == 'Giỏi') bg-success
                                        @elseif($dk->diem->trang_thai == 'Khá') bg-info
                                        @elseif($dk->diem->trang_thai == 'Trung bình') bg-warning
                                        @else bg-danger
                                        @endif
                                    @else bg-secondary
                                    @endif">
                                    {{ $dk->diem->trang_thai ?? 'Chưa nhập' }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" 
                                    onclick="saveDiem({{ $dk->id }})">
                                    <i class="bi bi-save"></i> Lưu
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('giang-vien.diems.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại
    </a>
</div>
@endsection

@push('scripts')
<script>
function saveDiem(dangKyMonHocId) {
    const cc = document.getElementById(`cc_${dangKyMonHocId}`).value;
    const gk = document.getElementById(`gk_${dangKyMonHocId}`).value;
    const ck = document.getElementById(`ck_${dangKyMonHocId}`).value;
    const nghi = document.getElementById(`nghi_${dangKyMonHocId}`).value;

    if (!cc || !gk || !ck) {
        alert('Vui lòng nhập đủ 3 điểm: Chuyên cần, Giữa kỳ, Cuối kỳ');
        return;
    }

    fetch('{{ route("giang-vien.diems.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            dang_ky_mon_hoc_id: dangKyMonHocId,
            diem_chuyen_can: cc,
            diem_giua_ky: gk,
            diem_cuoi_ky: ck,
            so_buoi_nghi: nghi
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật DTB và trạng thái
            document.getElementById(`dtb_${dangKyMonHocId}`).textContent = data.diem_trung_binh;
            
            const statusEl = document.getElementById(`status_${dangKyMonHocId}`);
            statusEl.textContent = data.trang_thai;
            statusEl.className = 'badge ' + 
                (data.trang_thai === 'Giỏi' ? 'bg-success' : 
                 data.trang_thai === 'Khá' ? 'bg-info' : 
                 data.trang_thai === 'Trung bình' ? 'bg-warning' : 'bg-danger');
            
            alert('Lưu điểm thành công!');
        } else {
            alert('Lỗi: ' + (data.error || 'Không thể lưu điểm'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi lưu điểm');
    });
}
</script>
@endpush
