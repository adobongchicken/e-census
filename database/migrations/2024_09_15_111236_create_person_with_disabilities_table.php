<?php

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
        Schema::create('person_with_disabilities', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('present_house');
            $table->string('present_sitio');
            $table->string('present_baranggay');
            $table->string('present_city');
            $table->string('present_province');
            $table->string('province_house');
            $table->string('province_sitio');
            $table->string('province_baranggay');
            $table->string('province_city');
            $table->string('province_province');
            $table->string('sex');
            $table->string('civil_status');
            $table->string('date_of_birth');
            $table->string('place_of_birth');
            $table->string('contact_no');
            $table->string('email');
            $table->string('height');
            $table->string('weight');
            $table->string('religion');
            $table->timestamps();
        });

        DB::table('person_with_disabilities')->insert([
            'last_name' => 'Uchiha',
            'first_name' => 'Kevs',
            'middle_name' => 'Middle Man',
            'present_house' => 'Blk 8 Lot 8',
            'present_sitio' => 'Ancop Canada Homes',
            'present_baranggay' => 'Bagumbayan',
            'present_city' => 'Quezon City',
            'present_province' => 'Metro Manila',
            'province_house' => 'N/A',
            'province_sitio' => 'N/A',
            'province_baranggay' => 'N/A',
            'province_city' => 'N/A',
            'province_province' => 'N/A',
            'sex' => 'Male',
            'civil_status' => 'Single',
            'date_of_birth' => '2004-03-28',
            'place_of_birth' => 'Camarines Sur',
            'contact_no' => '09123456789',
            'email' => 'kevs.plcomp@gmail.com',
            'height' => '165',
            'weight' => '54',
            'religion' => 'Catholic',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_with_disabilities');
    }
};
