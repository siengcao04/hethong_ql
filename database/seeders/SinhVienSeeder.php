<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\SinhVien;
use App\Models\Lop;
use Illuminate\Support\Facades\Hash;

class SinhVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sinhVienRole = Role::where('name', 'sinh-vien')->first();
        $lops = Lop::all();

        $sinhViens = [
            // Lớp CNTT-K21A
            ['ma' => 'SV001', 'ho_ten' => 'Nguyễn Văn A', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-01-15', 'sdt' => '0901234001', 'dia_chi' => 'Hà Nội', 'lop' => 'CNTT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV002', 'ho_ten' => 'Trần Thị B', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-03-20', 'sdt' => '0901234002', 'dia_chi' => 'Hải Phòng', 'lop' => 'CNTT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV003', 'ho_ten' => 'Lê Văn C', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-05-10', 'sdt' => '0901234003', 'dia_chi' => 'Đà Nẵng', 'lop' => 'CNTT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV004', 'ho_ten' => 'Phạm Thị D', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-07-22', 'sdt' => '0901234004', 'dia_chi' => 'Hà Nội', 'lop' => 'CNTT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV005', 'ho_ten' => 'Hoàng Văn E', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-09-05', 'sdt' => '0901234005', 'dia_chi' => 'Nghệ An', 'lop' => 'CNTT-K21A', 'khoa_hoc' => '2021-2025'],
            
            // Lớp CNTT-K21B
            ['ma' => 'SV006', 'ho_ten' => 'Đỗ Thị F', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-02-14', 'sdt' => '0901234006', 'dia_chi' => 'Hà Nội', 'lop' => 'CNTT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV007', 'ho_ten' => 'Vũ Văn G', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-04-18', 'sdt' => '0901234007', 'dia_chi' => 'Hồ Chí Minh', 'lop' => 'CNTT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV008', 'ho_ten' => 'Bùi Thị H', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-06-25', 'sdt' => '0901234008', 'dia_chi' => 'Cần Thơ', 'lop' => 'CNTT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV009', 'ho_ten' => 'Đinh Văn I', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-08-12', 'sdt' => '0901234009', 'dia_chi' => 'Hà Nội', 'lop' => 'CNTT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV010', 'ho_ten' => 'Dương Thị K', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-10-30', 'sdt' => '0901234010', 'dia_chi' => 'Hải Phòng', 'lop' => 'CNTT-K21B', 'khoa_hoc' => '2021-2025'],
            
            // Lớp CNTT-K22
            ['ma' => 'SV011', 'ho_ten' => 'Phan Văn L', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2004-01-08', 'sdt' => '0901234011', 'dia_chi' => 'Đà Nẵng', 'lop' => 'CNTT-K22', 'khoa_hoc' => '2022-2026'],
            ['ma' => 'SV012', 'ho_ten' => 'Lý Thị M', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2004-03-16', 'sdt' => '0901234012', 'dia_chi' => 'Hà Nội', 'lop' => 'CNTT-K22', 'khoa_hoc' => '2022-2026'],
            ['ma' => 'SV013', 'ho_ten' => 'Mai Văn N', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2004-05-21', 'sdt' => '0901234013', 'dia_chi' => 'Vinh', 'lop' => 'CNTT-K22', 'khoa_hoc' => '2022-2026'],
            ['ma' => 'SV014', 'ho_ten' => 'Võ Thị O', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2004-07-19', 'sdt' => '0901234014', 'dia_chi' => 'Huế', 'lop' => 'CNTT-K22', 'khoa_hoc' => '2022-2026'],
            ['ma' => 'SV015', 'ho_ten' => 'Tô Văn P', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2004-09-27', 'sdt' => '0901234015', 'dia_chi' => 'Hà Nội', 'lop' => 'CNTT-K22', 'khoa_hoc' => '2022-2026'],
            
            // Lớp KINH TẾ-K21A
            ['ma' => 'SV016', 'ho_ten' => 'Hồ Văn Q', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-02-11', 'sdt' => '0901234016', 'dia_chi' => 'Hồ Chí Minh', 'lop' => 'KT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV017', 'ho_ten' => 'Cao Thị R', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-04-23', 'sdt' => '0901234017', 'dia_chi' => 'Hà Nội', 'lop' => 'KT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV018', 'ho_ten' => 'Tạ Văn S', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-06-15', 'sdt' => '0901234018', 'dia_chi' => 'Đà Nẵng', 'lop' => 'KT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV019', 'ho_ten' => 'Lương Thị T', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-08-28', 'sdt' => '0901234019', 'dia_chi' => 'Hải Phòng', 'lop' => 'KT-K21A', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV020', 'ho_ten' => 'Hà Văn U', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-10-07', 'sdt' => '0901234020', 'dia_chi' => 'Hà Nội', 'lop' => 'KT-K21A', 'khoa_hoc' => '2021-2025'],
            
            // Lớp KINH TẾ-K21B
            ['ma' => 'SV021', 'ho_ten' => 'Đặng Thị V', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-03-09', 'sdt' => '0901234021', 'dia_chi' => 'Nghệ An', 'lop' => 'KT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV022', 'ho_ten' => 'Từ Văn W', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-05-17', 'sdt' => '0901234022', 'dia_chi' => 'Hà Nội', 'lop' => 'KT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV023', 'ho_ten' => 'Nghiêm Thị X', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-07-24', 'sdt' => '0901234023', 'dia_chi' => 'Hồ Chí Minh', 'lop' => 'KT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV024', 'ho_ten' => 'La Văn Y', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-09-13', 'sdt' => '0901234024', 'dia_chi' => 'Cần Thơ', 'lop' => 'KT-K21B', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV025', 'ho_ten' => 'Ông Thị Z', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-11-20', 'sdt' => '0901234025', 'dia_chi' => 'Hà Nội', 'lop' => 'KT-K21B', 'khoa_hoc' => '2021-2025'],
            
            // Lớp NGOẠI NGỮ-K21
            ['ma' => 'SV026', 'ho_ten' => 'An Văn AA', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-01-25', 'sdt' => '0901234026', 'dia_chi' => 'Hà Nội', 'lop' => 'NN-K21', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV027', 'ho_ten' => 'Bích Thị BB', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-04-12', 'sdt' => '0901234027', 'dia_chi' => 'Đà Nẵng', 'lop' => 'NN-K21', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV028', 'ho_ten' => 'Châu Văn CC', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-06-29', 'sdt' => '0901234028', 'dia_chi' => 'Hải Phòng', 'lop' => 'NN-K21', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV029', 'ho_ten' => 'Diệu Thị DD', 'gioi_tinh' => 'Nữ', 'ngay_sinh' => '2003-08-16', 'sdt' => '0901234029', 'dia_chi' => 'Hà Nội', 'lop' => 'NN-K21', 'khoa_hoc' => '2021-2025'],
            ['ma' => 'SV030', 'ho_ten' => 'Ên Văn EE', 'gioi_tinh' => 'Nam', 'ngay_sinh' => '2003-10-22', 'sdt' => '0901234030', 'dia_chi' => 'Hồ Chí Minh', 'lop' => 'NN-K21', 'khoa_hoc' => '2021-2025'],
        ];

        foreach ($sinhViens as $svData) {
            $lop = $lops->where('ma_lop', $svData['lop'])->first();
            
            if (!$lop) {
                $this->command->warn('Không tìm thấy lớp: ' . $svData['lop']);
                continue;
            }

            // Tạo User
            $email = strtolower(str_replace(' ', '.', $svData['ho_ten'])) . '@student.hethong.com';
            $user = User::create([
                'name' => $svData['ho_ten'],
                'email' => $email,
                'password' => Hash::make('123456'),
                'role_id' => $sinhVienRole->id,
            ]);

            // Tạo Sinh viên
            SinhVien::create([
                'user_id' => $user->id,
                'ma_sinh_vien' => $svData['ma'],
                'ho_ten' => $svData['ho_ten'],
                'gioi_tinh' => $svData['gioi_tinh'],
                'ngay_sinh' => $svData['ngay_sinh'],
                'sdt' => $svData['sdt'],
                'dia_chi' => $svData['dia_chi'],
                'lop_id' => $lop->id,
                'khoa_hoc' => $svData['khoa_hoc'],
            ]);
        }

        $this->command->info('Đã tạo ' . count($sinhViens) . ' sinh viên');
    }
}
