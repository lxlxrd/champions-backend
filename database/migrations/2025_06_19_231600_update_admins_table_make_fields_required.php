<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Supprimer la colonne name si elle existe
            if (Schema::hasColumn('admins', 'name')) {
                $table->dropColumn('name');
            }

            // Ajouter first_name si elle n’existe pas
            if (!Schema::hasColumn('admins', 'first_name')) {
                $table->string('first_name')->nullable(false)->after('id');
            }

            // Ajouter last_name si elle n’existe pas
            if (!Schema::hasColumn('admins', 'last_name')) {
                $table->string('last_name')->nullable(false)->after('first_name');
            }

            // Modifier les autres colonnes pour les rendre obligatoires
            $table->string('phone')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('role')->default('admin')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('admins', 'last_name')) {
                $table->dropColumn('last_name');
            }

            if (!Schema::hasColumn('admins', 'name')) {
                $table->string('name')->after('id');
            }

            $table->string('phone')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('role')->nullable()->default('admin')->change();
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });
    }
};

