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
        Schema::create('post_seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId(('season_id'))
                ->constrained('seasons')
                ->cascadeOnDelete();
            $table->foreignId(('post_id'))
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->foreignId(('admin_id'))->constrained('admins')
                ->cascadeOnDelete();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_seasons');
    }
};
