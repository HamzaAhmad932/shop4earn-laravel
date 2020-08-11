<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Reward type name or Type title');
            $table->unsignedTinyInteger('status')->comment('Active/inactive status of reward type');
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
        Schema::dropIfExists('reward_types');
    }
}
