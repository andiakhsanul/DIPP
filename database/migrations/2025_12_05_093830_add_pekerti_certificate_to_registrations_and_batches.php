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
        // Add requires_pekerti_certificate to batches table
        Schema::table('batches', function (Blueprint $table) {
            $table->boolean('requires_pekerti_certificate')->default(false)->after('training_type');
        });

        // Add pekerti_certificate to registrations table
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('pekerti_certificate')->nullable()->after('surat_tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn('requires_pekerti_certificate');
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('pekerti_certificate');
        });
    }
};
