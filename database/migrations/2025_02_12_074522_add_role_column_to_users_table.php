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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable(); // Add a nullable profile_picture column
            $table->string('role')->default('user')->after('profile_picture'); // Add a role column with a default value
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_picture'); // Remove profile_picture column
            $table->dropColumn('role'); // Remove role column
        });
    }
};
