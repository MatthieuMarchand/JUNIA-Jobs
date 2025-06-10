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
        Schema::table('student_profile_contract_types', function (Blueprint $table) {
            $table->string('contract_duration')->nullable()->after('contract_type_id');
            $table->string('work_study_rhythm')->nullable()->after('contract_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profile_contract_types', function (Blueprint $table) {
            $table->dropColumn(['contract_duration', 'work_study_rhythm']);
        });
    }
};
