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
        Schema::create('workshop_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('report_date'); // Date of the week?
            $table->timestamps();

            $table->boolean('extra_activities')->default(false);
            $table->text('extra_activities_description')->nullable();
            $table->boolean('materials_provided')->default(true);
            $table->boolean('grid_provided')->default(true);
            $table->text('observations')->nullable();
            $table->text('feedback');


            $table->uuid('instructor_id');
            $table->foreign('instructor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_reports');
    }
};
