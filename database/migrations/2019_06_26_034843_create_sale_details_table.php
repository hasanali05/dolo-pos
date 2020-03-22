<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('sale_id')->unsigned();
            $table->integer('quantity')->default(1);
            $table->integer('inventory_id')->unsigned();
            $table->double('price',8,2)->default(0);
            $table->string('warranty_duration')->nullable();
            $table->enum('warranty_type', ['days', 'months', 'years'])->default('days')->nullable();
            $table->string('warranty_start')->nullable();
            $table->string('warranty_end')->nullable();
            $table->string('unique_code')->nullable();

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
        Schema::dropIfExists('sale_details');
    }
}
