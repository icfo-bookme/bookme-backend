<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceTable extends Migration
{
    public function up()
    {
        Schema::create('price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id'); // Foreign key for property_unit
            $table->decimal('price', 10, 2); // Price with precision
            $table->dateTime('effectfrom');
            $table->dateTime('effective_till')->nullable();
            $table->timestamps(); // Created_at and Updated_at

            $table->foreign('unit_id')->references('unit_id')->on('property_unit')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('price');
    }
}

