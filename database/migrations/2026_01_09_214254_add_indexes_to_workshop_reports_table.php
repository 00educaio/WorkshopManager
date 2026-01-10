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
        Schema::table('workshop_reports', function (Blueprint $table) {
            $table->index('instructor_id');

            $table->index('report_date');

            $table->index(['report_date', 'instructor_id']);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_reports', function (Blueprint $table) {
            $table->dropIndex(['instructor_id']);
            $table->dropIndex(['report_date']);
            $table->dropIndex(['report_date', 'instructor_id']);
        });
    }
};
