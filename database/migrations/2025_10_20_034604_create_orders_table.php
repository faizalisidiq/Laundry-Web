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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('customer_name',100);
            $table->timestamps();
            $table->string('phone',20);
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Diambil'])->default('Menunggu');
            $table->string('resi', 20);
            $table->decimal('total_harga', 10, 2);
            $table->dateTime('tanggal_pemesanan');
            $table->dateTime('tanggal_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
