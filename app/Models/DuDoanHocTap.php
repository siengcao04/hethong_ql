<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuDoanHocTap extends Model
{
    protected $fillable = [
        'sinh_vien_id',
        'mon_hoc_id',
        'dang_ky_mon_hoc_id',
        'du_doan',
        'ket_qua_du_doan',
        'do_tin_cay',
    ];

    protected $casts = [
        'do_tin_cay' => 'decimal:2',
    ];

    // Relations
    public function dangKyMonHoc()
    {
        return $this->belongsTo(DangKyMonHoc::class);
    }

    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class);
    }

    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class);
    }
}
