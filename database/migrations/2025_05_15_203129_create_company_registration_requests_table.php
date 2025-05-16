<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_registration_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('company_name');
            $table->string('message');
            $table->boolean('approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_registration_requests');
    }
};
