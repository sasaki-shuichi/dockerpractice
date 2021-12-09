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
            $table->integer('user_id')->unsigned()->unique();
            $table->string('name', 100);
            $table->string('tel', 100);
            $table->text('address');
            $table->text('company');
            $table->text('user_name');
            $table->text('country');
            $table->String('element', 100);
            $table->String('birth', 100);
            $table->text('comment');
            $table->tinyInteger('locked_flg')->default(0);
            $table->integer('error_count')->unsigned()->default(0);
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
        Schema::dropIfExists('users');
    }
}
