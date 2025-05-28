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
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'name')) {
                $table->string('name');
            }
            if (!Schema::hasColumn('rooms', 'description')) {
                $table->text('description');
            }
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->integer('capacity')->default(2);
            }
            if (!Schema::hasColumn('rooms', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2);
            }
            if (!Schema::hasColumn('rooms', 'has_wifi')) {
                $table->boolean('has_wifi')->default(false);
            }
            if (!Schema::hasColumn('rooms', 'has_ac')) {
                $table->boolean('has_ac')->default(false);
            }
            if (!Schema::hasColumn('rooms', 'has_tv')) {
                $table->boolean('has_tv')->default(false);
            }
            if (!Schema::hasColumn('rooms', 'has_fridge')) {
                $table->boolean('has_fridge')->default(false);
            }
            if (!Schema::hasColumn('rooms', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('rooms', 'image')) {
                $table->string('image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'description',
                'capacity',
                'price_per_night',
                'has_wifi',
                'has_ac',
                'has_tv',
                'has_fridge',
                'is_active',
                'image'
            ]);
        });
    }
};
