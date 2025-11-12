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
        Schema::table('orders', function (Blueprint $table) {
            // Kolom untuk status WhatsApp
            $table->boolean('wa_sent')->default(false)->after('status');
            $table->timestamp('wa_sent_at')->nullable()->after('wa_sent');
            
            // Kolom untuk pembayaran
            $table->enum('payment_status', ['Lunas', 'Belum Lunas'])
                  ->default('Belum Lunas')
                  ->after('wa_sent_at');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'wa_sent', 
                'wa_sent_at', 
                'payment_status', 
                'paid_amount'
            ]);
        });
    }
};