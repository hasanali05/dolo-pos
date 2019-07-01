<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned();
            $table->string('unique_code');

            $table->integer('quantity')->default(1);
            $table->double('buying_price',8,2)->default(0);
            $table->double('selling_price',8,2)->default(0);
            $table->enum('status', ['inventory', 'sold', 'warranty', 'damage'])->default('inventory');

            $table->integer('supplier_id')->unsigned();
            $table->integer('supply_id')->unsigned();

            $table->integer('customer_id')->unsigned();
            $table->integer('sale_id')->unsigned();

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
        Schema::dropIfExists('inventories');
    }
}
