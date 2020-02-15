<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_code');
            $table->double('product_price');
            $table->string('pv')->nullable();
            $table->string('bv')->nullable();
            $table->string('tb')->nullable();
            $table->unsignedBigInteger('color_id');
            $table->unsignedBigInteger('size_id');
            $table->string('quantity');
            $table->string('discount');
            $table->string('IP');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_details');
    }
}
