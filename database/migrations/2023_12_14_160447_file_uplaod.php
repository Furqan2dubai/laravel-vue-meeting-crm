<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('path')->nullable(); 
            $table->string('type')->nullable(); //'jpg, .pdf
            $table->text('description')->nullable();  
            $table->string('parent')->nullable(); //table or associate
            $table->integer('ref_id')->nullable();            
            $table->string('ref_no')->nullable(); 
            $table->integer('added_by')->nullable();           
            $table->timestamps();
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('file_uploads');
    }
};
