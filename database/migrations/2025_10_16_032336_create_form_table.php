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
        Schema::create('pendaftaran_pekerti', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nidn_nidk_nuptk');
            $table->string('institusi');
            $table->string('nomor_hp');
            $table->string('email')->unique();
            $table->string('bukti_transfer')->nullable();
            $table->string('npwp_ktp')->nullable();
            $table->string('surat_tugas')->nullable();
            $table->longText('tanda_tangan')->nullable(); // disimpan dalam bentuk base64 atau path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pekerti');
    }
};
