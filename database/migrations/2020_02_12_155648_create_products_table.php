<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_code')->nullable();
            $table->string('product_name');
            $table->text('product_description');
            $table->double('product_price');
            $table->string('pv')->nullable()->comment('Product volume');
            $table->string('bv')->nullable()->comment('Sales volume bonus');
            $table->string('tb')->nullable()->comment('Team bonus');
            $table->double('purchase_cost');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('discount')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('net')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('products');
    }
}
