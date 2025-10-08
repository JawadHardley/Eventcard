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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('title', 50);
            $table->string('email', 100)->nullable();
            $table->string('phone', 20);
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('delivery_method', ['sms', 'email', 'whatsapp']);

            // $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->integer('order_id');
            $table->boolean('verified')->default(false);
            $table->timestamp('card_sent_at')->nullable();
            $table->text('more')->nullable();
            $table->enum('attendance_status', ['active', 'onhold', 'complete'])->default('active');
            $table->string('qrcode', 255)->nullable();
            $table->string('invitation_code', 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
