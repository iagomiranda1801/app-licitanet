<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Marca;
use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    /**
     * Define o estado padrão da fábrica.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->word, // Gera um nome fictício para o produto
            'marca_cod' => Marca::factory()->create()->cod_marca, // Cria uma nova marca usando a factory
            'descricao' => $this->faker->sentence, // Descrição aleatória
            'estoque' => $this->faker->numberBetween(0, 100), // Estoque aleatório entre 0 e 100
            'valor' => $this->faker->randomFloat(2, 10, 1000), // Valor aleatório entre 10 e 1000 com 2 casas decimais
            'cod_cidade' => Cidade::factory()->create()->id, // Cria uma nova cidade usando a factory
        ];
    }
}
