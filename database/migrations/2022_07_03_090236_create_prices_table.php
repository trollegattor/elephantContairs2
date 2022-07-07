<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('carrier',['JSON','XML']);
            $table->unsignedInteger('origin');
            $table->unsignedInteger('destination');
            $table->decimal('price_container',6,2,true);
            $table->date('expiration_date');
            $table->unsignedInteger('currency_id');
            $table->timestamps();
            $table->foreign('origin')
                ->references('id')
                ->on('ports');
            $table->foreign('destination')
                ->references('id')
                ->on('ports');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};
