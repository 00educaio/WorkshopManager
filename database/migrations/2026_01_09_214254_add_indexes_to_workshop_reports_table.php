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
            $table->index('instructor_id', 'idx_wr_instructor_id');
            $table->index('report_date', 'idx_wr_report_date');
            $table->index(['instructor_id', 'report_date'], 'idx_wr_instructor_date');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_reports', function (Blueprint $table) {
            $table->dropIndex('idx_wr_instructor_id');
            $table->dropIndex('idx_wr_report_date');
            $table->dropIndex('idx_wr_instructor_date');
        });
    }
};
