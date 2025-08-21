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
        Schema::create('report_card_subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_card_id');
            $table->unsignedBigInteger('subject_id');
            $table->decimal('average', 5, 2)->nullable();
            $table->text('teacher_remark')->nullable();
            $table->timestamps();

            $table->foreign('report_card_id')->references('id')->on('report_cards')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_card_subjects');
    }
};
