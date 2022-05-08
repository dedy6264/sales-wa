<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_name',128);
            $table->string('client_phone',20);
            $table->string('client_address',128);
            $table->string('status',1)->nullable();
            $table->timestamps();
            $table->string('created_by', 128);
            $table->string('updated_by', 128)->nullable();
        });
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',64);
            $table->text('message');
            $table->timestamps();
            $table->string('created_by', 128);
            $table->string('updated_by', 128)->nullable();
        });
        Schema::create('send', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('index')->unique();
            $table->integer('message_id');
            $table->integer('client_id');
            $table->integer('status'); //0=blm terkirim, 1=terkirim
            $table->integer('broadcast_type_id'); //1=all, 2=current number
            $table->timestamps();
            $table->string('created_by', 128);
            $table->string('updated_by', 128)->nullable();
            $table->foreign('message_id')->references('id')->on('message');
            // $table->foreign('client_id')->references('id')->on('client');
        });
        Schema::create('broadcast_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',20);
            $table->timestamps();
            $table->string('created_by', 128);
            $table->string('updated_by', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client');
    }
}
