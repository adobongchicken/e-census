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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string('location');
            $table->date('date');
            $table->time('time');
            $table->string('venue');
            $table->integer('duration');
            $table->longText('description')->nullable();
            $table->string('residency_requirements');
            $table->string('visual_impairment')->nullable();
            $table->string('speech_language_impairment')->nullable();
            $table->string('learning_disabilities')->nullable();
            $table->string('hearing_impairment')->nullable();
            $table->string('intellectual_disabilities')->nullable();
            $table->string('mobility_impairment')->nullable();
            $table->string('psycho_social_disabilities')->nullable();
            $table->string('multiple_disabilities')->nullable();
            $table->string('other_disabilities')->nullable();
            $table->string('organizer_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('organizer_name_2')->nullable();
            $table->string('contact_number_2')->nullable();
            $table->string('email_2')->nullable();
            $table->string('organizer_name_3')->nullable();
            $table->string('contact_number_3')->nullable();
            $table->string('email_3')->nullable();
            $table->string('event_image');
            $table->boolean('cancelled')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
