<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyUnitTable extends Migration
{
    public function up()
    {
        Schema::create('property_unit', function (Blueprint $table) {
            $table->id('unit_id');
            $table->unsignedBigInteger('property_id'); // Foreign key for property
            $table->enum('unit_category', ['room', 'seat'])->nullable(false);
            $table->string('unit_no', 50)->nullable(false);
            $table->string('unit_name', 100)->nullable();
            $table->string('unit_type', 50)->nullable(); // Bed type
            $table->integer('person_allowed')->default(1);
            $table->boolean('additionalbed')->default(false);
            $table->string('mainimg')->nullable();
            $table->boolean('isactive')->default(true);
            $table->timestamps(); // Created_at and Updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_unit');
    }
}

