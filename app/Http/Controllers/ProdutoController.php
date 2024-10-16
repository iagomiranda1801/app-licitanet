<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $cod_cidade = $request->input('cod_cidade');
        $cod_marca = $request->input('marca_cod');
        $estoque = $request->input('estoque');
        $vlInit = $request->input('vlinit');
        $vlFim = $request->input('vlFim');

        $query = Produto::query()->with(['marca', 'cidade']);

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($cod_cidade) {
            $query->where('cod_cidade', $cod_cidade);
        }
        if ($cod_marca) {
            $query->where('marca_cod', $cod_marca);
        }
        if ($estoque) {
            $query->where('estoque', $estoque);
        }
        if ($vlInit !== null) {
            if ($vlInit <= $vlFim) {
                $query->whereBetween('valor', [$vlInit, $vlFim]);
            }
        }


        $produtos = $query->get();
        $cidades = Cidade::query()->get();
        $marcas = Marca::query()->get();

        // Calcular a soma e a média dos valores dos produtos
        $soma = $produtos->sum('valor');
        $media = $produtos->avg('valor');

        // Retornando para a view 'pages.index-produto' com os produtos, marcas, cidades, soma e média
        return view('pages.index-produto', compact('produtos', 'marcas', 'cidades', 'soma', 'media'));
    }


    public function show($id) {}

    public function create()
    {
        $cidades = Cidade::all();
        $marcas = Marca::all();
        return view('pages.produto-create', compact('cidades', 'marcas'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'marca_cod' => 'required|integer',
            'descricao' => 'nullable|string',
            'estoque' => 'required|integer',
            'valor' => 'required|numeric',
            'cod_cidade' => 'required|integer',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser um texto.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'marca_cod.required' => 'O campo marca é obrigatório.',
            'marca_cod.integer' => 'O campo marca deve ser um número inteiro.',
            'descricao.string' => 'O campo descrição deve ser um texto.',
            'estoque.required' => 'O campo estoque é obrigatório.',
            'estoque.integer' => 'O campo estoque deve ser um número inteiro.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O campo valor deve ser um número.',
            'cod_cidade.required' => 'O campo cidade é obrigatório.',
            'cod_cidade.integer' => 'O campo cidade deve ser um número inteiro.',
        ]);

        // Encontrar o produto pelo ID
        $produto = Produto::findOrFail($id);

        // Atualizar o produto com os dados validados
        $produto->update($request->all());

        // Redirecionar de volta com mensagem de sucesso
        return redirect()->route('produto.index')->with('success', 'Produto atualizado com sucesso!');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'marca_cod' => 'required|integer',
            'descricao' => 'nullable|string',
            'estoque' => 'required|integer',
            'valor' => 'required|numeric',
            'cod_cidade' => 'required|exists:cidades,id',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser um texto.',
            'name.max' => 'O nome não pode exceder 255 caracteres.',

            'marca_cod.required' => 'O código da marca é obrigatório.',
            'marca_cod.integer' => 'O código da marca deve ser um número inteiro.',

            'descricao.string' => 'A descrição deve ser um texto.',

            'quantidade_estoque.required' => 'A quantidade em estoque é obrigatória.',
            'quantidade_estoque.integer' => 'A quantidade em estoque deve ser um número inteiro.',

            'valor.required' => 'O valor do produto é obrigatório.',
            'valor.numeric' => 'O valor deve ser um número.',

            'cod_cidade.required' => 'A cidade é obrigatória.',
            'cod_cidade.exists' => 'A cidade selecionada não existe.',

            'marca_cod.required' => 'A marca é obrigatória.',
            'marca_cod.exists' => 'A marca selecionada não existe.'
        ]);


        Produto::create($validatedData);

        return redirect()->route('produto.index')->with('success', 'Produto cadastrado com sucesso.');
    }

    public function destroy($id)
    {
        try {
            $produto = Produto::query()->find($id);
            if ($produto->estoque > 0) {
                return redirect()->route('produto.index')->with('error', 'Erro ao excluir, produto com saldo em estoque');
            } else {
                $produto->delete();
                return redirect()->route('produto.index')->with('success', 'Produto excluida com sucesso.');
            }
        } catch (\Throwable $th) {
            return redirect()->route('produto.index')->with('error', 'Erro ao excluir');
        }
    }
}
