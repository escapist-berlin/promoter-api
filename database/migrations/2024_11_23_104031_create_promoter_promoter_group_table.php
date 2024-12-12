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
        Schema::create('promoter_promoter_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promoter_id')->constrained()->onDelete('cascade');
            $table->foreignId('promoter_group_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['promoter_id', 'promoter_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoter_promoter_group');
    }
};
