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
        Schema::create('lich_trinhs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tuyen');
            $table->integer('id_xe');
            $table->integer('id_tai_xe');
            $table->integer('thoi_luong_hieu_chinh');
            $table->time('thoi_luong_nghi');
            $table->time('thoi_gian_bat_dau');
            $table->date('ngay_khoi_chay');
            $table->integer('tinh_trang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_trinhs');
    }
};
