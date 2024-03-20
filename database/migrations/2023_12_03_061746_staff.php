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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->unique();
            $table->string('staff_no')->nullable();
            $table->text('details')->nullable();
            $table->integer('added_by')->nullable();
            $table->timestamps();
        });

        DB::table('staff')->insert(
            array(
                'name' => 'Furqan Hussain',
                'email' => 'furqan@Kaikei.com',
                'tel' => '786',
                'staff_no' => 'Furqan007'
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
