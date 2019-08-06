<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('entry_date');

            $table->integer('account_id')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->string('detail')->nullable();

            $table->double('debit', 8, 2)->default(0);
            $table->double('credit', 8, 2)->default(0);
            $table->double('balance', 8, 2)->default(0);

            $table->integer('created_by')->unsigned()->default(1)->nullable();
            $table->integer('modified_by')->unsigned()->default(1)->nullable();
            
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
        Schema::dropIfExists('ledgers');
    }
}
