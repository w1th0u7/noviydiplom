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
        if (!Schema::hasTable('excursions')) {
            Schema::create('excursions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('location');
                $table->string('region');
                $table->integer('duration')->default(1);
                $table->decimal('price', 10, 2);
                $table->string('image')->nullable();
                $table->string('audience_type')->default('all');
                $table->integer('min_age')->default(0);
                $table->integer('max_age')->default(99);
                $table->integer('available_seats')->default(20);
                $table->json('features')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excursions');
    }
};
