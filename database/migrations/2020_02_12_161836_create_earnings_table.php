<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('direct_bonus')->default(0)->comment('Direct sponsor bonus');
            $table->string('team_bonus')->default(0)->comment('Team bonus / compensation bonus');
            $table->string('sales_bonus')->default(0)->comment('Sales volume bonus');
            $table->string('carry_forward')->default(0)->comment('Leftover amount');
            $table->string('position')->comment('Left or right side in tree');
            $table->string('paid')->default(0)->comment('Amount which is paid');
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
        Schema::dropIfExists('earnings');
    }
}
