<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guest_id')->nullable()->constrained()->nullOnDelete();

            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);
            $table->unsignedTinyInteger('pets')->default(0);

            $table->enum('status', [
                'new_request', 'pending', 'confirmed', 'rejected',
                'cancelled', 'completed', 'no_show', 'hold', 'blocked',
            ])->default('new_request');

            $table->enum('source', [
                'website', 'booking_com', 'airbnb', 'phone', 'email', 'agency', 'other',
            ])->default('website');

            $table->string('locale', 5)->default('hr');

            $table->decimal('total_price', 8, 2)->default(0);
            $table->decimal('discount_amount', 8, 2)->default(0);

            $table->text('guest_note')->nullable();
            $table->text('internal_note')->nullable();

            $table->timestamp('hold_expires_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['house_id', 'check_in', 'check_out']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
