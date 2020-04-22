<?php

use App\PayoutRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('payment_method_id');
            $table->string('amount');
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->default(PayoutRequest::PENDING_STATUS)->comment('0=Pending, 1=Paid, 2=Rejected');
            $table->dateTime('date_requested')->nullable()->comment('Customer requested for payout at date.');
            $table->dateTime('date_cleared')->nullable()->comment('Decision made for the request at date.');
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
        Schema::dropIfExists('payout_requests');
    }
}
