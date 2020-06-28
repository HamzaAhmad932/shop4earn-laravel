<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('default_sponsor_id')->comment('Default sponsor ID in case of no sponsor is defined during customer registration.');
            $table->smallInteger('admin_charges_percentage')->comment('Percentage of admin charges at payout request by customer.');
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
        Schema::dropIfExists('custom_settings');
    }
}
