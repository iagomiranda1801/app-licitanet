<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarcaFactory extends Factory
{
    
    // Definir o modelo associado a essa factory
    protected $model = Marca::class;

    /**
     * Define o estado padrão para a marca.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company, // Gera um nome de empresa aleatório
            'cod_marca' => $this->faker->unique()->numerify('######'), // Gera um código de marca único
            'descricao' => $this->faker->sentence, // Gera uma frase aleatória para a descrição
        ];
    }
}
