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
        Schema::create('du_doan_hoc_taps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinh_vien_id')->constrained('sinh_viens')->onDelete('cascade')->comment('ID sinh viên');
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->onDelete('cascade')->comment('ID môn học');
            $table->enum('du_doan', ['Giỏi', 'Khá', 'Trung bình', 'Yếu'])->comment('Kết quả dự đoán');
            $table->decimal('do_tin_cay', 5, 2)->nullable()->comment('Độ tin cậy (0-100%)');
            $table->timestamp('thoi_gian_du_doan')->useCurrent()->comment('Thời gian dự đoán');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('du_doan_hoc_taps');
    }
};
