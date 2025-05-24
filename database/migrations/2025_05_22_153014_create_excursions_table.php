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
        Schema::create('excursions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('location');
            $table->string('region');
            $table->integer('duration');
            $table->decimal('price', 10, 2);
            $table->string('image');
            $table->enum('audience_type', ['preschool', 'school', 'adult', 'all']);
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->integer('available_seats')->default(20);
            $table->text('features')->nullable(); // JSON строка с особенностями экскурсии
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excursions');
    }
};
