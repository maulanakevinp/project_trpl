<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');
            $table->string('nik')->unique();
            $table->string('nik_file')->nullable();
            $table->string('kk')->unique()->nullable();
            $table->string('kk_file')->nullable();
            $table->string('name');
            $table->string('image');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('religion_id');
            $table->unsignedBigInteger('marital_id');
            $table->string('phone_number', 13)->nullable();
            $table->text('address');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('job');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('user_role')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('religion_id')->references('id')->on('religions')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('marital_id')->references('id')->on('maritals')
                ->onDelete('cascade')->onUpdate('cascade');
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
