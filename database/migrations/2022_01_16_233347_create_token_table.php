<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
         Schema::create('token', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->string('idsesion');
            $table->string('documento');
            $table->string('celular');
            $table->decimal('monto', 10, 2);
            $table->smallInteger('procesado');
            $table->bigInteger('validez', 0);
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
        Schema::dropIfExists('token');
    }
}
