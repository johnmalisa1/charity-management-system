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
        Schema::table('volunteer_activities', function (Blueprint $table) {
            // Add status column for Active / Inactive / Pending tracking
            $table->enum('status', ['Active', 'Inactive', 'Pending'])->default('Pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_activities', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

