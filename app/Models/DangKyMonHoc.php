<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DangKyMonHoc extends Model
{
    protected $fillable = [
        'sinh_vien_id',
        'mon_hoc_id',
        'giang_vien_id',
        'hoc_ky',
        'nam_hoc',
    ];

    // Relations
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class);
    }

    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class);
    }

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class);
    }

    public function diem()
    {
        return $this->hasOne(Diem::class);
    }
}
