<?php

use App\Models\Event;
use App\Models\PersonWithDisability;
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
        Schema::create('program_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PersonWithDisability::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Event::class);
            $table->string('program_name');
            $table->string('baranggay');
            $table->string('sex');
            $table->string('disabilities');
            $table->string('attended');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_attendances');
    }
};
