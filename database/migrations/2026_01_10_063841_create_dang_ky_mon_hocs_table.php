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
        Schema::create('dang_ky_mon_hocs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinh_vien_id')->constrained('sinh_viens')->onDelete('cascade')->comment('ID sinh viên');
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->onDelete('cascade')->comment('ID môn học');
            $table->foreignId('giang_vien_id')->nullable()->constrained('giang_viens')->onDelete('set null')->comment('ID giảng viên');
            $table->integer('hoc_ky')->comment('Học kỳ (1, 2, 3)');
            $table->string('nam_hoc')->comment('Năm học (VD: 2023-2024)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dang_ky_mon_hocs');
    }
};
