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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // Basic Details
            $table->string('order_name'); // name of the event order
            $table->string('event_host')->nullable(); // person hosting
            $table->string('event_type')->nullable(); // e.g. wedding, concert
            $table->enum('event_status', ['completed', 'active', 'cancelled'])->default('active');
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending');

            // Timing and Location
            $table->date('event_date')->nullable();
            $table->time('arrival_time')->nullable();
            $table->date('reminder_date')->nullable();
            $table->string('timezone')->nullable();
            $table->string('event_location')->nullable();

            // Description and Media
            $table->text('event_desc')->nullable();
            $table->string('card_link')->nullable();

            // SEO & Limits
            $table->string('slug')->nullable(); // SEO-friendly URL
            $table->string('guest_limit')->nullable();

            // Relations
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
