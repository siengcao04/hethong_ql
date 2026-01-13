<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('ID user');
            $table->string('ma_sinh_vien')->unique()->comment('Mã sinh viên');
            $table->string('ho_ten')->comment('Họ tên');
            $table->date('ngay_sinh')->nullable()->comment('Ngày sinh');
            $table->enum('gioi_tinh', ['Nam', 'Nữ', 'Khác'])->default('Nam')->comment('Giới tính');
            $table->string('sdt', 15)->nullable()->comment('Số điện thoại');
            $table->text('dia_chi')->nullable()->comment('Địa chỉ');
            $table->foreignId('lop_id')->nullable()->constrained('lops')->onDelete('set null')->comment('ID lớp');
            $table->string('khoa_hoc')->comment('Khóa học (VD: 2020-2024)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
