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
        $cod_marca = $request->input('cod_marca');
        $estoque = $request->input('estoque');
        $vlInit = $request->input('vlinit');
        $vlFim = $request->input('vlfim');

        $query = Produto::query()->with(['marca', 'cidade']);

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($cod_cidade) {
            $query->where('cod_cidade', $cod_cidade);
        }

        if ($cod_marca) {
            $query->where('cod_marca', $cod_marca);
        }

        if ($estoque) {
            $query->where('estoque', $estoque);
        }

        if ($vlInit) {
            $query->where('valor', '>=', $vlInit)->where('valor', '<=', $vlFim);
        }

        $produtos = $query->get();
        $cidades = Cidade::query()->get();
        $marcas = Marca::query()->get();
        // Retornando para a view 'marcas.index' com as marcas
        return view('pages.index-produto', compact('produtos', 'marcas', 'cidades'));
    }
    
    public function show($id) {

    }

    public function create()
    {
        $cidades = Cidade::all();
        $marcas = Marca::all();
        return view('pages.produto-create', compact('cidades', 'marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cod_marca' => 'required|integer',
            'descricao' => 'nullable|string',
            'quantidade_estoque' => 'required|integer',
            'valor' => 'required|numeric',
            'cidade_id' => 'required|exists:cidades,id',
            'marca_id' => 'required|exists:marcas,id'
        ]);

        $produto = new Produto();
        $produto->name = $request->name;
        $produto->cod_marca = $request->cod_marca;
        $produto->descricao = $request->descricao;
        $produto->quantidade_estoque = $request->quantidade_estoque;
        $produto->valor = $request->valor;
        $produto->cidade_id = $request->cidade_id;
        $produto->marca_id = $request->marca_id;
        $produto->save();

        return redirect()->route('produto.index')->with('success', 'Produto cadastrado com sucesso.');
    }
}
