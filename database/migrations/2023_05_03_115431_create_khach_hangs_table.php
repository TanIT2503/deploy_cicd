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
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ho_va_ten')->nullable();
            $table->string('ho_lot');
            $table->string('ten');
            $table->integer('id_xe')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('so_dien_thoai');
            $table->string('hash_mail')->nullable();
            $table->integer('gioi_tinh');
            $table->integer('loai_tai_khoan')->nullable();
            $table->string('hash_reset')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_hangs');
    }
};
