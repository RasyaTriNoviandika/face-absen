<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit', 'alfa'])->default('hadir');
            $table->string('check_in_photo')->nullable();
            $table->string('check_out_photo')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Prevent duplicate attendance on same date
            $table->unique(['employee_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};