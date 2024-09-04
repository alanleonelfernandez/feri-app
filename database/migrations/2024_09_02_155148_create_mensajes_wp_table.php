<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mensajes_wp', function (Blueprint $table) {
            $table->id();
            $table->text('cuerpo');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mensajes_wp');
    }
};
