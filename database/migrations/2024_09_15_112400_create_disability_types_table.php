<?php

use App\Models\PersonWithDisability;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disability_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PersonWithDisability::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('visual_impairment')->nullable();
            $table->string('speech_language_impairment')->nullable();
            $table->string('learning_disabilities')->nullable();
            $table->string('hearing_impairment')->nullable();
            $table->string('intellectual_disabilities')->nullable();
            $table->string('mobility_impairment')->nullable();
            $table->string('psycho_social_disabilities')->nullable();
            $table->string('multiple_disabilities')->nullable();
            $table->string('other_disabilities')->nullable();
            $table->string('profile');
            $table->timestamps();
        });

        DB::table('disability_types')->insert([
            'person_with_disability_id' => 1,
            'visual_impairment' => 'Blindness',
            'learning_disabilities' => 'ADHD',
            'profile' => '1726459910_xczcas.jpg'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disability_types');
    }
};
