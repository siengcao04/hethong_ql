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
        Schema::create('diems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dang_ky_mon_hoc_id')->constrained('dang_ky_mon_hocs')->onDelete('cascade')->comment('ID đăng ký môn học');
            $table->decimal('diem_chuyen_can', 4, 2)->nullable()->comment('Điểm chuyên cần (0-10)');
            $table->decimal('diem_giua_ky', 4, 2)->nullable()->comment('Điểm giữa kỳ (0-10)');
            $table->decimal('diem_cuoi_ky', 4, 2)->nullable()->comment('Điểm cuối kỳ (0-10)');
            $table->decimal('diem_trung_binh', 4, 2)->nullable()->comment('Điểm trung bình (0-10)');
            $table->integer('so_buoi_nghi')->default(0)->comment('Số buổi nghỉ');
            $table->enum('trang_thai', ['Giỏi', 'Khá', 'Trung bình', 'Yếu'])->nullable()->comment('Trạng thái');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diems');
    }
};
