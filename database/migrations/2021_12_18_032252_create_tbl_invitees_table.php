<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblInviteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_invitees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->integer('eventId')->unsigned();
            $table->foreign('eventId')->references('id')->on('tbl_events');
            $table->date('invited_on')->nullable();
            $table->text('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('tbl_invitees');
    }
}
