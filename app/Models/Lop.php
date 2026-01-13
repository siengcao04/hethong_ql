<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    protected $fillable = [
        'ma_lop',
        'ten_lop',
        'khoa_id',
        'khoa_hoc',
    ];

    // Relations
    public function khoa()
    {
        return $this->belongsTo(Khoa::class);
    }

    public function sinhViens()
    {
        return $this->hasMany(SinhVien::class);
    }
}
