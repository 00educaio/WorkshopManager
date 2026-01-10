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
        Schema::table('workshop_report_school_classes', function (Blueprint $table) {
            $table->index('workshop_report_id', 'idx_wrsc_workshop_report_id');
            $table->index('school_class_id', 'idx_wrsc_school_class_id');
            
            $table->index(['school_class_id', 'workshop_report_id'], 'idx_wrsc_school_workshop');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshop_report_school_classes', function (Blueprint $table) {
            $table->dropIndex('idx_wrsc_workshop_report_id');
            $table->dropIndex('idx_wrsc_school_class_id');
            $table->dropIndex('idx_wrsc_school_workshop');
        });
    }
};
