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
        Schema::create('interview_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_profile_id')->constrained()->onDelete('cascade');
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
