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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->text('descripcion')->nullable();
            $table->foreignId('id_categoria')->constrained('categorias');
            $table->string('marca')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('costo', 10, 2);
            $table->decimal('precio_ml', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->decimal('porcentaje_ganancia', 5, 2)->nullable();
            $table->string('link_imagen')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
