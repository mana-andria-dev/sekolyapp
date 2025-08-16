<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->foreignId('tenant_id')
                  ->after('id')
                  ->constrained()
                  ->onDelete('cascade');
        });

        Schema::table('dossiers', function (Blueprint $table) {
            $table->foreignId('tenant_id')
                  ->after('id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('dossiers', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }

};
