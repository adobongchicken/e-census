<?php

use App\Models\Baranggay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Baranggay::class);
            $table->string('account_type');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('contact_no');
            $table->string('contact_address');
            $table->string('username');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        DB::table('users')->insert([
            'baranggay_id' => 1,
            'account_type' => 'Super Admin',
            'full_name' => 'Main Administrator',
            'email' => 'admin@gmail.com',
            'contact_no' => '09123456789',
            'contact_address' => 'Quezon City',
            'username' => 'administrator000',
            'password' => Hash::make('admin000')
        ]);
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
