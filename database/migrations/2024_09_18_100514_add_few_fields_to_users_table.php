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
            $table->text('biography')->nullable()->after('role');
            $table->text('website')->nullable()->after('biography');
            $table->boolean('is_private')->default(true)->after('website');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('biography');
            $table->dropColumn('website');
            $table->dropColumn('is_private');
        });
    }
};
