<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $fillable = [
        'user_id',
        'ma_giang_vien',
        'ho_ten',
        'ngay_sinh',
        'gioi_tinh',
        'sdt',
        'dia_chi',
        'khoa_id',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function khoa()
    {
        return $this->belongsTo(Khoa::class);
    }

    public function dangKyMonHocs()
    {
        return $this->hasMany(DangKyMonHoc::class);
    }
}
