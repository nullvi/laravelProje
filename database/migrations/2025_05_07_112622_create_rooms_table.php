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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('room_number');
            $table->string('type'); // Single, Double, Suite vs.
            $table->integer('capacity');
            $table->decimal('price_per_night', 10, 2);
            $table->text('description')->nullable();
            $table->text('amenities')->nullable(); // JSON formatted
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Her otelde benzersiz oda numarası olmasını sağlayalım
            $table->unique(['hotel_id', 'room_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
