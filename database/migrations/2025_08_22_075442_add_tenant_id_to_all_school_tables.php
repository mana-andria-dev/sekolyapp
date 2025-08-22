<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'users', 
            'students', 
            'teachers', 
            'classes', 
            'subjects',
            'assignments', 
            'attendances', 
            'evaluations', 
            'report_cards',
            'student_grades', 
            'student_files', 
            'dossiers', 
            'presences'
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasColumn($tableName, 'tenant_id')) {
                // Étape 1 : Ajouter colonne nullable
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
                });

                // Étape 2 : Mettre tenant_id = 1 pour les anciennes données
                if (DB::table($tableName)->count() > 0) {
                    DB::table($tableName)->update(['tenant_id' => 1]);
                }

                // Étape 3 : Ajouter contrainte FK
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->foreign('tenant_id', $tableName . '_tenant_id_foreign')
                          ->references('id')->on('tenants')
                          ->onDelete('cascade');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'users', 
            'students', 
            'teachers', 
            'classes', 
            'subjects',
            'assignments', 
            'attendances', 
            'evaluations', 
            'report_cards',
            'student_grades', 
            'student_files', 
            'dossiers', 
            'presences'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->dropForeign($tableName . '_tenant_id_foreign');
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
