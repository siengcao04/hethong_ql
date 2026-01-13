<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    protected $fillable = [
        'ma_khoa',
        'ten_khoa',
        'mo_ta',
    ];

    // Relations
    public function lops()
    {
        return $this->hasMany(Lop::class);
    }

    public function giangViens()
    {
        return $this->hasMany(GiangVien::class);
    }

    // Relationship: Khoa -> Lop -> SinhVien
    public function sinhViens()
    {
        return $this->hasManyThrough(SinhVien::class, Lop::class);
    }
}
