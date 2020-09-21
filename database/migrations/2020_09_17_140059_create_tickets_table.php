<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->Integer('uspNumber')->unsigned()->nullable();
            $table->string('passangerFullName', 150);
            $table->string('incomingFromAirportCode', 3);
            $table->string('incomingToAirportCode', 3);
            $table->dateTime('departDate');
            $table->string('outcomingFromAirportCode', 3);
            $table->string('outcomingToAirportCode', 3);
            $table->dateTime('returnDate');
            $table->boolean('international');
            $table->decimal('price',8,2,)->default(0);
            $table->string('passport')->nullable();
            $table->decimal('boardingTax',6,2,)->default(0);
            $table->decimal('agencyTax',6,2,)->default(0);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
