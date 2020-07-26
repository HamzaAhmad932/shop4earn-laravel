<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCappingColsToSalesBonusDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_bonus_details', function (Blueprint $table) {

            $table->string('dividing_percentage')->nullable()->after('carry_forward');
            $table->unsignedTinyInteger('capped')->nullable()->after('carry_forward');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_bonus_details', function (Blueprint $table) {
            //
        });
    }
}
