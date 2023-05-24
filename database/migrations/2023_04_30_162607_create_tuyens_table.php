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
        Schema::create('tuyens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_tuyen');
            $table->string('diem_don_khach');
            $table->string('diem_tra_khach');
            $table->integer('thoi_luong');
            $table->date('ngay_khoi_chay');
            $table->string('avatar');
            $table->text('mo_ta');
            $table->integer('tinh_trang');
            $table->float('gia_ve');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuyens');
    }
};
