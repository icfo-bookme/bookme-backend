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
            Schema::create('property_summary', function (Blueprint $table) {
                $table->id();
                $table->foreignId('property_id') ;// Assuming there's a 'properties' table
                $table->string('value');
                $table->string('image')->nullable();
                $table->enum('display', ['yes', 'no'])->default('yes');
                $table->timestamps();
            });
        }
        
        public function down()
        {
            Schema::dropIfExists('property_summary');
        }
        
};
