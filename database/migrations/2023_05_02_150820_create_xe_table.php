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
        Schema::create('xe', function (Blueprint $table) {
            $table->id();
            $table->string('bien_so_xe');
            $table->integer('tinh_trang');
            $table->integer('hang_doc');
            $table->integer('hang_ngang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xe');
    }
};
