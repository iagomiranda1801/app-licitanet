<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id(); // Cria a coluna id como chave primária
            $table->bigInteger('marca_cod'); // Cria a coluna cod_marca como string
            $table->string('name'); // Cria a coluna name como string
            $table->text('descricao')->nullable(); // Cria a coluna descricao como texto, permitindo valores nulos
            $table->decimal('valor', 8, 2); // Cria a coluna valor para o preço do produto (com 8 dígitos no total e 2 casas decimais)
            $table->timestamps(); // Cria as colunas created_at e updated_at
            $table->foreign('marca_cod')->references('cod_marca')->on('marcas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
