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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->tinyInteger('pago')->default(0);
            $table->string('forma_pago');
            $table->date('fecha_pedido');
            $table->foreignId('id_evento')->nullable()->constrained('evento');
            $table->foreignId('id_entrega')->nullable()->constrained('entregas');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
