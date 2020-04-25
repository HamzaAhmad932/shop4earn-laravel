<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDonationColInTablePayoutRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payout_requests', function (Blueprint $table) {
            $table->string('donation')->default('0')->after('amount');
            $table->string('admin_percentage')->default('0')->after('amount');
            $table->string('admin_charges')->default('0')->after('amount');
            $table->string('payable_amount')->default('0')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payout_requests', function (Blueprint $table) {
            //
        });
    }
}
