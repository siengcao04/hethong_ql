<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $fillable = [
        'ma_mon',
        'ten_mon',
        'so_tin_chi',
        'mo_ta',
    ];

    // Relations
    public function dangKyMonHocs()
    {
        return $this->hasMany(DangKyMonHoc::class);
    }

    public function duDoanHocTaps()
    {
        return $this->hasMany(DuDoanHocTap::class);
    }
}
