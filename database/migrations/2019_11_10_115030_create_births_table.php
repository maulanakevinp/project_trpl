<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBirthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('births', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('letter_id')->nullable();
            $table->string('name');
            $table->enum('gender',['Laki-laki','Perempuan']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('religion',['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu']);
            $table->text('address');
            $table->tinyInteger('order');
            $table->string('name_parent');
            $table->tinyInteger('age');
            $table->enum('gender_parent',['Laki-laki','Perempuan']);
            $table->string('job');
            $table->text('address_parent');
            $table->string('file')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('letter_id')->references('id')->on('letters')
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
        Schema::dropIfExists('births');
    }
}
