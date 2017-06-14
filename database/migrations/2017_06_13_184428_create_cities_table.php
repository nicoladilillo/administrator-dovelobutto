<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name', 100);
          $table->rememberToken();
          $table->timestamps();
          $table->integer('dump_id')->unsigned();
          $table->foreign('dump_id')->references('ID')->on('dumps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            Schema::dropIfExists('cities');
        });
    }
}
