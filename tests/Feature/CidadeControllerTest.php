<?php

namespace Tests\Feature;

use App\Models\Cidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CidadeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_cidades()
    {
        // Cria algumas cidades de exemplo
        Cidade::factory()->create(['name' => 'Cidade 1']);
        Cidade::factory()->create(['name' => 'Cidade 2']);

        // Faz uma requisição GET para o método index
        $response = $this->get(route('cidade.index'));

        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifica se a view está correta
        $response->assertViewIs('pages.index-cidade');

        // Verifica se as cidades estão sendo passadas para a view
        $response->assertViewHas('cidades', Cidade::all());
    }

    public function test_store_creates_new_cidade()
    {
        // Dados de exemplo para criar uma nova cidade
        $data = [
            'name' => 'Cidade Teste',
        ];

        // Simula uma requisição POST para o método store
        $response = $this->post(route('cidade.store'), $data);

        // Verifica se foi redirecionado corretamente
        $response->assertRedirect(route('cidade.index'));

        // Verifica se a mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Cidade criada com sucesso!');

        // Verifica se a cidade foi criada no banco de dados
        $this->assertDatabaseHas('cidades', ['name' => 'Cidade Teste']);
    }

    public function test_update_edits_existing_cidade()
    {
        // Cria uma cidade de exemplo no banco de dados
        $cidade = Cidade::factory()->create();

        // Dados atualizados
        $data = [
            'name' => 'Cidade Atualizada',
        ];

        // Simula uma requisição PUT para atualizar a cidade
        $response = $this->put(route('cidade.update', $cidade->id), $data);

        // Verifica se foi redirecionado corretamente
        $response->assertRedirect(route('cidade.index'));

        // Verifica se a mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Cidade atualizada com sucesso.');

        // Verifica se a cidade foi atualizada no banco de dados
        $this->assertDatabaseHas('cidades', ['name' => 'Cidade Atualizada']);
    }

    public function test_destroy_deletes_cidade()
    {
        // Cria uma cidade de exemplo no banco de dados
        $cidade = Cidade::factory()->create();

        // Simula uma requisição DELETE para excluir a cidade
        $response = $this->delete(route('cidade.destroy', $cidade->id));

        // Verifica se foi redirecionado corretamente
        $response->assertRedirect(route('cidade.index'));

        // Verifica se a mensagem de sucesso foi retornada
        $response->assertSessionHas('success', 'Cidade excluida com sucesso.');

        // Verifica se a cidade foi excluída do banco de dados
        $this->assertDatabaseMissing('cidades', ['id' => $cidade->id]);
    }
}
