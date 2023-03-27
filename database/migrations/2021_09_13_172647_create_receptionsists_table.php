<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionsistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptionsists', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('admin_id');
            $table->string('firstName');
            $table->string('fatherName');
            $table->string('lastName');
            $table->string('phoneNumber');
            $table->string('image')->nullable();
            $table->longText('aboutYou')->nullable();
            $table->string('userName');
            $table->string('password');
            $table->boolean('isContracted')->default(1);
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
        Schema::dropIfExists('receptionsists');
    }
}