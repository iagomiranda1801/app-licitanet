<?php

use App\Models\Produto;
use App\Models\Marca;
use App\Models\Cidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_products()
    {
        // Cria algumas instâncias de Produto
        Produto::factory()->count(5)->create();

        // Faz a requisição GET para a rota index
        $response = $this->get(route('produto.index'));
     
        // Verifica se a resposta foi bem-sucedida
        $response->assertStatus(200);

        // Verifica se a view está correta
        $response->assertViewIs('pages.index-produto');

        // Verifica se a view contém os produtos, marcas e cidades
        $response->assertViewHasAll(['produtos', 'marcas', 'cidades']);
    }

    public function test_store_creates_new_produto()
    {
        // Cria instâncias de Marca e Cidade para associar ao Produto
        $marca = Marca::factory()->create();
        $cidade = Cidade::factory()->create();

        // Dados de exemplo para criar um novo Produto
        $data = [
            'name' => 'Produto Teste',
            'marca_cod' => $marca->cod_marca,
            'descricao' => 'Uma descrição de teste',
            'estoque' => 10,
            'valor' => 50.00,
            'cod_cidade' => $cidade->id,
        ];

        // Simula a requisição POST para criar o produto
        $response = $this->post(route('produto.store'), $data);
       
        // Verifica se houve redirecionamento correto
        $response->assertRedirect(route('produto.index'));

        // Verifica se a mensagem de sucesso foi exibida
        $response->assertSessionHas('success', 'Produto cadastrado com sucesso.');

        // Verifica se o produto foi inserido no banco de dados
        $this->assertDatabaseHas('produtos', ['name' => 'Produto Teste']);
    }

    public function test_update_edits_existing_produto()
    {
        // Cria uma instância de Produto
        $produto = Produto::factory()->create();
           
        // Novos dados para atualizar o Produto
        $data = [
            'name' => 'Produto Atualizado',
            'marca_cod' => $produto->marca_cod,
            'descricao' => 'Nova descrição',
            'estoque' => 5,
            'valor' => 100.00,
            'cod_cidade' => $produto->cod_cidade,
        ];

        // Simula a requisição PUT para atualizar o Produto
        $response = $this->put(route('produto.update', $produto->id), $data);
       
        // Verifica se houve redirecionamento correto
        $response->assertRedirect(route('produto.index'));

        // Verifica se a mensagem de sucesso foi exibida
        $response->assertSessionHas('success', 'Produto atualizado com sucesso!');

        // Verifica se os dados do produto foram atualizados no banco de dados
        $this->assertDatabaseHas('produtos', ['name' => 'Produto Atualizado']);
    }

    public function test_destroy_deletes_produto()
    {
        
        // Cria um produto com estoque 0 (para poder ser deletado)
        $produto = Produto::factory()->create(['estoque' => 0]);
        
        // Simula a requisição DELETE para excluir o Produto
        $response = $this->delete(route('produto.destroy', $produto->id));

        // Verifica se houve redirecionamento correto
        $response->assertRedirect(route('produto.index'));

        // Verifica se a mensagem de sucesso foi exibida
        $response->assertSessionHas('success', 'Produto excluida com sucesso.');

        // Verifica se o produto foi excluído do banco de dados
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }
}
