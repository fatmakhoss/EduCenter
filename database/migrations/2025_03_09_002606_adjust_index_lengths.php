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
        if (Schema::hasTable('cache')) { // Vérifie si la table existe
            Schema::table('cache', function (Blueprint $table) {
                $table->dropPrimary();
                $table->primary('key', 'cache_key_primary')->length(191);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cache')) { // Vérifie si la table existe
            Schema::table('cache', function (Blueprint $table) {
                $table->dropPrimary();
                $table->primary('key');
            });
        }
    }
};


