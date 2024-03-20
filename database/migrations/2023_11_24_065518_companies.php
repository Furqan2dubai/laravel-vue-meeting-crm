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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('tax_no')->unique();
            $table->string('tel')->nullable();
            $table->string('email')->unique();
            $table->string('org')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->string('currency')->nullable();
            $table->text('address')->nullable();
            $table->text('payment_detail')->nullable();
            $table->text('logo')->nullable(); 
            $table->float('payable')->default(0);
            $table->float('receivable')->default(0); 
            $table->timestamps();
        });

        DB::table('companies')->insert(
            array(
                'name' => 'Kaikei',
                'tel' => '123',
                'email' => 'admin@Kaikei.com',
                'tax_no' => '',
                'org' => '',
                'country'=>'Malaysia'
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
