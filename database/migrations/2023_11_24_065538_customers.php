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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('staff')->nullable();
            $table->integer('staff_id')->nullable();
            $table->integer('added_by')->nullable();
            $table->timestamps();
        });

        DB::table('customers')->insert(
            array(
                'name' => 'Chin',
                'tel' => '123987',
                'email' => 'chin@gmail.com',
                'city' => 'Johor City',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'Postcode' => '001',
                'staff' => 'Furqan',
                'staff_id' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
