<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diem extends Model
{
    protected $fillable = [
        'dang_ky_mon_hoc_id',
        'diem_chuyen_can',
        'diem_giua_ky',
        'diem_cuoi_ky',
        'diem_trung_binh',
        'so_buoi_nghi',
        'trang_thai',
    ];

    protected $casts = [
        'diem_chuyen_can' => 'decimal:2',
        'diem_giua_ky' => 'decimal:2',
        'diem_cuoi_ky' => 'decimal:2',
        'diem_trung_binh' => 'decimal:2',
    ];

    // Relations
    public function dangKyMonHoc()
    {
        return $this->belongsTo(DangKyMonHoc::class);
    }

    // Auto calculate diem_trung_binh
    public static function boot()
    {
        parent::boot();

        static::saving(function ($diem) {
            if ($diem->diem_chuyen_can !== null && $diem->diem_giua_ky !== null && $diem->diem_cuoi_ky !== null) {
                $diem->diem_trung_binh = ($diem->diem_chuyen_can * 0.1) + 
                                         ($diem->diem_giua_ky * 0.3) + 
                                         ($diem->diem_cuoi_ky * 0.6);
                
                // Tính trạng thái
                if ($diem->diem_trung_binh >= 8) {
                    $diem->trang_thai = 'Giỏi';
                } elseif ($diem->diem_trung_binh >= 6.5) {
                    $diem->trang_thai = 'Khá';
                } elseif ($diem->diem_trung_binh >= 5) {
                    $diem->trang_thai = 'Trung bình';
                } else {
                    $diem->trang_thai = 'Yếu';
                }
            }
        });
    }
}
