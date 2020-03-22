<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listjobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('checklist_id')->unsigned();
            $table->string('job');
            $table->boolean('is_done')->default(0);
            $table->integer('created_by')->default(1);
            $table->softDeletes();
            $table->timestamps();

            
            $table->foreign('checklist_id')->references('id')->on('checklists')
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
        Schema::dropIfExists('listjobs');
    }
}
