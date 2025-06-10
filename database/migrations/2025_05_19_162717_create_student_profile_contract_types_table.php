<?php

use App\Models\ContractType;
use App\Models\StudentProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_profile_contract_types', function (Blueprint $table) {
            $table->foreignIdFor(StudentProfile::class);
            $table->foreignIdFor(ContractType::class);
            $table->string('contract_duration')->nullable();
            $table->string('alternance_temps_entreprise')->nullable();
            $table->string('rhythm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profile_contract_types');
    }
};
