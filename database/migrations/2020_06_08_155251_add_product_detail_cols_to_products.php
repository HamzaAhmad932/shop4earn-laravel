<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductDetailColsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('tab_1_title')->nullable();
            $table->text('tab_1_content')->nullable();
            $table->string('tab_2_title')->nullable();
            $table->text('tab_2_content')->nullable();
            $table->string('tab_3_title')->nullable();
            $table->text('tab_3_content')->nullable();
            $table->string('tab_4_title')->nullable();
            $table->text('tab_4_content')->nullable();
            $table->string('tab_5_title')->nullable();
            $table->text('tab_5_content')->nullable();
            $table->dropColumn('specification');
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tab_1_title')->nullable();
            $table->dropColumn('tab_1_content')->nullable();
            $table->dropColumn('tab_2_title')->nullable();
            $table->dropColumn('tab_2_content')->nullable();
            $table->dropColumn('tab_3_title')->nullable();
            $table->dropColumn('tab_3_content')->nullable();
            $table->dropColumn('tab_4_title')->nullable();
            $table->dropColumn('tab_4_content')->nullable();
            $table->dropColumn('tab_5_title')->nullable();
            $table->dropColumn('tab_5_content')->nullable();
            $table->text('specification');
            $table->text('description');
        });
    }
}
