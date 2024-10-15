<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $cod_marca = $request->input('cod_marca');

        $query = Cidade::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        
        if ($cod_marca) {
            $query->where('cod_marca', $cod_marca);
        }

        $cidades = $query->get();

        // Retornando para a view 'marcas.index' com as marcas
        return view('pages.index-cidade', compact('cidades'));
    }

    
    public function create()
    {
        return view('pages.cidade-create');
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos na requisição
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'cod_cidade' => 'required|string|max:50|unique:marcas,cod_marca',
        ], [
            'name.required' => 'O nome da marca é obrigatório.',
            'cod_cidade.required' => 'O código da marca é obrigatório.',
            'cod_cidade.unique' => 'Esse código de marca já está em uso.',
        ]);
    
        // Criar a nova marca com os dados validados
        Cidade::create($validatedData);
    
        // Retornar uma resposta de sucesso com a marca recém-criada
        return redirect()->route('cidade.index')->with('success', 'Cidade criada com sucesso!');
    }

    public function show() {

    }
}
