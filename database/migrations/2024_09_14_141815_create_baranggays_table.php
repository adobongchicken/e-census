<?php

use App\Models\Baranggay;
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
        Schema::create('baranggays', function (Blueprint $table) {
            $table->id();
            $table->string('baranggay_name');
            $table->string('baranggay_capt_name');
            $table->string('baranggay_location');
            $table->string('baranggay_contact')->nullable();
            $table->string('baranggay_desc')->nullable();
            $table->timestamps();
        });

        DB::table('baranggays')->insert([
            'baranggay_name' => 'Bagumbayan',
            'baranggay_capt_name' => 'Cererina San Juan',
            'baranggay_location' => 'Municipality of Bagumbayan'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baranggays');
    }
};
