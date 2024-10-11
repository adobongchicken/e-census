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
        Schema::create('educational_attainments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PersonWithDisability::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('elementary_school');
            $table->string('elementary_school_address');
            $table->string('high_school');
            $table->string('high_school_address');
            $table->string('vocational_school');
            $table->string('vocational_address');
            $table->string('college_school');
            $table->string('college_address');
            $table->timestamps();
        });

        DB::table('educational_attainments')->insert([
            'person_with_disability_id' => 1,
            'elementary_school' => 'Secret School',
            'elementary_school_address' => 'Secret School',
            'high_school' => 'Secret School',
            'high_school_address' => 'Secret School',
            'vocational_school' => 'Secret School',
            'vocational_address' => 'Secret School',
            'college_school' => 'Secret School',
            'college_address' => 'Secret School',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_attainments');
    }
};
