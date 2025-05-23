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
        Schema::table('aptitudes', function (Blueprint $table) {
            $table->timestamp('notified_at')->nullable()->after('aptitude_marks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aptitudes', function (Blueprint $table) {
            $table->dropColumn('notified_at');
        });
    }
};
