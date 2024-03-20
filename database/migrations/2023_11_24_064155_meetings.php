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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_no')->unique();
            $table->datetime('meeting_datetime')->nullable();
            $table->string('agenda')->nullable();
            $table->string('status')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('staff')->nullable();
            $table->integer('staff_id')->nullable();
            $table->text('note')->nullable(); 
            $table->integer('added_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
