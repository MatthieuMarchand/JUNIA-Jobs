<?php

use App\Models\CompanyProfile;
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
        Schema::create('interview_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CompanyProfile::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(StudentProfile::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->dateTime('sent');
            $table->date('invitation_date');
            $table->text('invitation_details');
            $table->enum('invitation_status', [
                'sent',
                'read',
                'accepted',
                'declined',
                'interview_scheduled',
                'completed',
            ])->default('sent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_invitations');
    }
};
