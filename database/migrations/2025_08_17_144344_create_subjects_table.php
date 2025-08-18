<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
