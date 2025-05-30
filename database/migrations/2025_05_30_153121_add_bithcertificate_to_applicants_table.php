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
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('entrance_type')->nullable()->after('card_id');
            $table->string('birth_certificate')->nullable()->after('date_of_birth');
            $table->string('institution')->nullable()->after('national_identity_card');
            $table->string('results_certificate')->nullable()->after('national_identity_card');
            $table->string('transcript')->nullable()->after('national_identity_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            //
        });
    }
};
