<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTable extends Migration
{
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id'); // Foreign key for property_unit
            $table->decimal('discount_percent', 5, 2)->nullable(); // Percentage discount
            $table->decimal('discount_amount', 10, 2)->nullable(); // Flat discount
            $table->dateTime('effectfrom');
            $table->dateTime('effective_till')->nullable();
            $table->timestamps(); // Created_at and Updated_at

            $table->foreign('unit_id')->references('unit_id')->on('property_unit')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount');
    }
}

