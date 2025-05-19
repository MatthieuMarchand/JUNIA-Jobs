<?php

use App\Models\ResearchArea;
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
        Schema::create('student_profile_research_areas', function (Blueprint $table) {
            $table->foreignIdFor(StudentProfile::class);
            $table->foreignIdFor(ResearchArea::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profile_research_areas');
    }
};
