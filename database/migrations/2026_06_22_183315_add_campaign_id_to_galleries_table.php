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
        Schema::table('galleries', function (Blueprint $table) {
            // Add campaign_id column, nullable
            $table->unsignedBigInteger('campaign_id')->nullable()->after('event_id');

            // Set up foreign key to campaigns table
            $table->foreign('campaign_id')
                  ->references('id')
                  ->on('campaigns')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Drop foreign key first, then column
            $table->dropForeign(['campaign_id']);
            $table->dropColumn('campaign_id');
        });
    }
};

