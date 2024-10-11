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
        Schema::create('submitted_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PersonWithDisability::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('account_id');
            $table->string('resident_id');
            $table->string('baranggay_id');
            $table->string('date_submission');
            $table->string('status');
            $table->string('submission_details')->nullable();
            $table->string('assisted_by');
            $table->timestamps();
        });
        DB::table('submitted_forms')->insert([
            'person_with_disability_id' => 1,
            'account_id' => 12382,
            'resident_id' => 3123123,
            'baranggay_id' => 1231232,
            'date_submission' => '2024-10-21',
            'status' => 'Active',
            'submission_details' => 'None',
            'assisted_by' => 'Main Administrator'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted_forms');
    }
};
