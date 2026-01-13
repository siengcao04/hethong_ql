<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $fillable = [
        'user_id',
        'ma_sinh_vien',
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'sdt',
        'dia_chi',
        'lop_id',
        'khoa_hoc',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lop()
    {
        return $this->belongsTo(Lop::class);
    }

    public function dangKyMonHocs()
    {
        return $this->hasMany(DangKyMonHoc::class);
    }

    public function duDoanHocTaps()
    {
        return $this->hasMany(DuDoanHocTap::class);
    }
}
