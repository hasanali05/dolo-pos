<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('checklist_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('checklist_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();


            $table->foreign('checklist_id')->references('id')->on('checklists')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_user');
        Schema::dropIfExists('checklists');
    }
}
