<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charity_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charity_id')->constrained('charities')->onDelete('cascade');
            $table->string('document_path'); // file path or storage reference
            $table->string('document_type'); // e.g. certificate, license
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charity_documents');
    }
};

