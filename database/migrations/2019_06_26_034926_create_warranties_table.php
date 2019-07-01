<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranties', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('purchase_id')->unsigned();
            $table->integer('inventory_id')->unsigned();
            $table->integer('sale_id')->unsigned();

            $table->string('warranty_duration')->nullable();
            $table->enum('warranty_type', ['days', 'months', 'years'])->default('days')->nullable();
            $table->string('warranty_start')->nullable();
            $table->string('warranty_end')->nullable();

            $table->string('issue_date')->nullable();
            $table->string('reason')->nullable();
            $table->string('return_date')->nullable();
            $table->enum('status', ['pending', 'accepted', 'declined', 'solved', 'returned', 'refunded'])->default('pending')->nullable();

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
        Schema::dropIfExists('warranties');
    }
}
