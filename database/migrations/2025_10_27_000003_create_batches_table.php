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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('training_type', ['pekerti', 'aa', 'tot']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('registration_open')->nullable();
            $table->dateTime('registration_close')->nullable();
            $table->integer('quota')->default(0);
            $table->enum('status', ['draft', 'open', 'closed', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
