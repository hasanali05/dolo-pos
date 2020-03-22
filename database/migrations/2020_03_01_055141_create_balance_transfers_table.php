<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_account_id')->unsigned()->nullable();
            $table->integer('to_account_id')->unsigned()->nullable();
            $table->double('amount', 16, 2)->default(0);
            $table->string('note')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('balance_transfers');
    }
}
