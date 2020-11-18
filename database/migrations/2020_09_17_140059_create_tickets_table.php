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
            $table->boolean('international');
            $table->string('passport', 250)->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('flight_segments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id')->unsigned();
            $table->string('fromAirportCode', 3);
            $table->string('toAirportCode', 3);
            $table->dateTime('departDate');
            $table->decimal('price',8,2,)->default(0);
            $table->decimal('boardingTax',6,2,)->default(0);
            $table->decimal('agencyTax',6,2,)->default(0);
            $table->decimal('discount',6,2,)->default(0);
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_segments');
        Schema::dropIfExists('tickets');
    }
}
