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
        Schema::table('registrations', function (Blueprint $table) {
            // Supprimer la contrainte existante
            $table->dropForeign(['player_id']);

            // Recréer la contrainte avec onDelete cascade
            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Supprimer la contrainte avec cascade
            $table->dropForeign(['player_id']);

            // Recréer la contrainte sans cascade
            $table->foreign('player_id')
                ->references('id')
                ->on('players');
        });
    }
};
