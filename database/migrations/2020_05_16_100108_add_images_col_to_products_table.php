<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesColToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->renameColumn('product_description', 'short_description');
            $table->text('description')->after('product_description')->nullable();
            $table->string('featured_img')->after('status');
            $table->string('img_1')->nullable()->after('status');
            $table->string('img_2')->nullable()->after('status');
            $table->string('img_3')->nullable()->after('status');
            $table->string('img_4')->nullable()->after('status');
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
            //
        });
    }
}
