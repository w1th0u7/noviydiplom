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
        Schema::table('tours', function (Blueprint $table) {
            $table->string('location')->nullable()->after('description');
            $table->integer('duration')->nullable()->after('location');
            $table->json('features')->nullable()->after('price');
            $table->enum('audience_type', ['preschool', 'school', 'adult', 'all'])->nullable()->after('features');
            $table->integer('min_age')->nullable()->after('audience_type');
            $table->integer('max_age')->nullable()->after('min_age');
            $table->integer('available_seats')->default(20)->after('max_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'duration',
                'features',
                'audience_type',
                'min_age',
                'max_age',
                'available_seats'
            ]);
        });
    }
};
