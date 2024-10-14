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
        Schema::create('marcas', function (Blueprint $table) {
            $table->id(); // Cria a coluna id como chave primária
            $table->bigInteger('cod_marca')->unique(); // Cria a coluna cod_marca como string e define como único
            $table->string('name'); // Cria a coluna name como string
            $table->text('descricao')->nullable(); // Cria a coluna descricao como texto, permitindo valores nulos
            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};
