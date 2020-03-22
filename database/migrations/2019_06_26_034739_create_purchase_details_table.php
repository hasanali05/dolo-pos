<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->double('price',8,2)->default(0);
            $table->string('warranty_duration')->nullable();
            $table->enum('warranty_type', ['days', 'months', 'years'])->default('days')->nullable();
            $table->string('unique_code');
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('purchase_details');
    }
}
