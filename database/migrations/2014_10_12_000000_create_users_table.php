<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->smallInteger('level_tree');
            $table->unsignedSmallInteger('client_id')->nullable();
            $table->unsignedSmallInteger('region_id')->nullable();
            $table->unsignedSmallInteger('group_id')->nullable();
            $table->unsignedSmallInteger('level_id')->nullable();
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
        Schema::dropIfExists('users');
    }
}
