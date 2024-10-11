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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PersonWithDisability::class);
            $table->string('guardian_full_name');
            $table->string('guardian_phone_number');
            $table->string('guardian_relationship');
            $table->timestamps();
        });

        DB::table('guardians')->insert([
            'person_with_disability_id' => 1,
            'guardian_full_name' => 'Robil Padilla',
            'guardian_phone_number' => '09123456789',
            'guardian_relationship' => 'Father'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
