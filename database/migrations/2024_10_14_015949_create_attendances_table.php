<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Create a migration for the attendance table
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade'); // Link to the programs table
            $table->foreignId('attendee_id')->constrained()->onDelete('cascade'); // Link to the attendees table
            $table->string('disabilities')->nullable(); // Store types of disabilities
            $table->string('sex')->nullable(); // Store sex of the attendee
            $table->string('baranggay')->nullable(); // Store barangay of the attendee
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
