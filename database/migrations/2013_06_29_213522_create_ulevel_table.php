<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulevel', function (Blueprint $table) {
            $table->smallIncrements('id', 6);
            $table->integer('level')->unique();
            $table->string('uraianlevel');
            $table->text('rule');
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
        Schema::dropIfExists('ulevel');
    }
}
