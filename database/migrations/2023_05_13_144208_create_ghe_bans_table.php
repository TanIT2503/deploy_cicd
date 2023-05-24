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
        Schema::create('ghe_bans', function (Blueprint $table) {
            $table->id();
            $table->string('ten_ghe');
            $table->integer('id_lich');
            $table->integer('co_the_ban');
            $table->integer('id_khach_hang')->nullable();
            $table->integer('trang_thai')->default(1);
            $table->text('ma_giao_dich')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ghe_bans');
    }
};
