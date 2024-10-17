<?php

namespace Tests\Feature;

use App\Models\Marca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarcaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_view_with_marcas()
    {
        // Cria algumas marcas de exemplo
        Marca::factory()->create(['name' => 'Marca 1']);
        Marca::factory()->create(['name' => 'Marca 2']);

        // Simula uma requisição para o método index
        $response = $this->get(route('marca.index'));

        // Verifica se o status da resposta é 200 (sucesso)
        $response->assertStatus(200);

        // Verifica se a view renderizada é a correta
        $response->assertViewIs('pages.index-marca');

        // Verifica se a view tem as marcas esperadas
        $response->assertViewHas('marcas', Marca::all());
    }

    public function test_store_creates_new_marca()
    {
        // Dados válidos para a requisição
        $data = [
            'name' => 'Marca Teste',
            'cod_marca' => '123456',
            'descricao' => 'Descrição da marca'
        ];

        // Simula uma requisição POST para criar uma nova marca
        $response = $this->post(route('marca.store'), $data);
      
        // Verifica se foi redirecionado corretamente
        $response->assertRedirect(route('marca.index'));

        // Verifica se uma mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Marca criada com sucesso!');

        // Verifica se a marca foi criada no banco de dados
        $this->assertDatabaseHas('marcas', ['name' => 'Marca Teste']);
    }

    public function test_update_updates_existing_marca()
    {
        // Cria uma marca no banco
        $marca = Marca::factory()->create();

        // Dados atualizados
        $data = [
            'name' => 'Marca Atualizada',
            'cod_marca' => '654321',
            'descricao' => 'Nova descrição'
        ];

        // Simula uma requisição PUT para atualizar a marca
        $response = $this->put(route('marca.update', $marca->id), $data);

        // Verifica se foi redirecionado corretamente
        $response->assertRedirect(route('marca.index'));

        // Verifica se uma mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Marca atualizada com sucesso.');

        // Verifica se a marca foi atualizada no banco de dados
        $this->assertDatabaseHas('marcas', ['name' => 'Marca Atualizada']);
    }

    public function test_destroy_deletes_existing_marca()
    {
        // Cria uma marca no banco
        $marca = Marca::factory()->create();
  
        // Simula uma requisição DELETE para excluir a marca
        $response = $this->delete(route('marca.destroy', $marca->id));

        // Verifica se foi redirecionado corretamente
        $response->assertRedirect(route('marca.index'));

        // Verifica se uma mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Marca excluida com sucesso.');

        // Verifica se a marca foi excluída do banco de dados
        $this->assertDatabaseMissing('marcas', ['id' => $marca->id]);
    }
}
