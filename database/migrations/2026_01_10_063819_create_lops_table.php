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
        Schema::create('lops', function (Blueprint $table) {
            $table->id();
            $table->string('ma_lop')->unique()->comment('Mã lớp');
            $table->string('ten_lop')->comment('Tên lớp');
            $table->foreignId('khoa_id')->constrained('khoas')->onDelete('cascade')->comment('ID khoa');
            $table->string('khoa_hoc')->comment('Khóa học (VD: 2020-2024)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lops');
    }
};
