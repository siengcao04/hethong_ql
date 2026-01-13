<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\GiangVien;
use App\Models\Khoa;
use Illuminate\Support\Facades\Hash;

class GiangVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $giangVienRole = Role::where('name', 'giang-vien')->first();
        $khoas = Khoa::all();

        $giangViens = [
            [
                'ma_giang_vien' => 'GV001',
                'ho_ten' => 'Nguyễn Văn An',
                'email' => 'nvan.an@hethong.com',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1980-05-15',
                'sdt' => '0912345001',
                'dia_chi' => 'Hà Nội',
                'khoa_id' => $khoas->where('ma_khoa', 'CNTT')->first()->id,
            ],
            [
                'ma_giang_vien' => 'GV002',
                'ho_ten' => 'Trần Thị Bình',
                'email' => 'tran.binh@hethong.com',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1985-08-20',
                'sdt' => '0912345002',
                'dia_chi' => 'Hà Nội',
                'khoa_id' => $khoas->where('ma_khoa', 'CNTT')->first()->id,
            ],
            [
                'ma_giang_vien' => 'GV003',
                'ho_ten' => 'Lê Văn Cường',
                'email' => 'le.cuong@hethong.com',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1982-03-12',
                'sdt' => '0912345003',
                'dia_chi' => 'Hải Phòng',
                'khoa_id' => $khoas->where('ma_khoa', 'CNTT')->first()->id,
            ],
            [
                'ma_giang_vien' => 'GV004',
                'ho_ten' => 'Phạm Thị Dung',
                'email' => 'pham.dung@hethong.com',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1987-11-25',
                'sdt' => '0912345004',
                'dia_chi' => 'Đà Nẵng',
                'khoa_id' => $khoas->where('ma_khoa', 'KT')->first()->id,
            ],
            [
                'ma_giang_vien' => 'GV005',
                'ho_ten' => 'Hoàng Văn Em',
                'email' => 'hoang.em@hethong.com',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1983-07-08',
                'sdt' => '0912345005',
                'dia_chi' => 'Hồ Chí Minh',
                'khoa_id' => $khoas->where('ma_khoa', 'KT')->first()->id,
            ],
            [
                'ma_giang_vien' => 'GV006',
                'ho_ten' => 'Đỗ Thị Phương',
                'email' => 'do.phuong@hethong.com',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1986-09-18',
                'sdt' => '0912345006',
                'dia_chi' => 'Hà Nội',
                'khoa_id' => $khoas->where('ma_khoa', 'NN')->first()->id,
            ],
            [
                'ma_giang_vien' => 'GV007',
                'ho_ten' => 'Vũ Văn Giang',
                'email' => 'vu.giang@hethong.com',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1984-02-28',
                'sdt' => '0912345007',
                'dia_chi' => 'Nghệ An',
                'khoa_id' => $khoas->where('ma_khoa', 'NN')->first()->id,
            ],
        ];

        foreach ($giangViens as $gvData) {
            // Tạo User
            $user = User::create([
                'name' => $gvData['ho_ten'],
                'email' => $gvData['email'],
                'password' => Hash::make('123456'),
                'role_id' => $giangVienRole->id,
            ]);

            // Tạo Giảng viên
            GiangVien::create([
                'user_id' => $user->id,
                'ma_giang_vien' => $gvData['ma_giang_vien'],
                'ho_ten' => $gvData['ho_ten'],
                'gioi_tinh' => $gvData['gioi_tinh'],
                'ngay_sinh' => $gvData['ngay_sinh'],
                'sdt' => $gvData['sdt'],
                'dia_chi' => $gvData['dia_chi'],
                'khoa_id' => $gvData['khoa_id'],
            ]);
        }

        $this->command->info('Đã tạo ' . count($giangViens) . ' giảng viên');
    }
}
