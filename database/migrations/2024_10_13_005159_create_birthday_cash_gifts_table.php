<?php

use App\Models\PersonWithDisability;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('birthday_cash_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PersonWithDisability::class);
            $table->string('status')->default('unreleased');
            $table->string('proof')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->timestamps();
        });

        DB::table('birthday_cash_gifts')->insert([
            'person_with_disability_id' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birthday_cash_gifts');
    }
};
