<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CidadeController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $cod_cidade = $request->input('cod_cidade');

        $query = Cidade::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($cod_cidade) {
            $query->where('id', $cod_cidade);
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
        ], [
            'name.required' => 'O nome da marca é obrigatório.',
        ]);

        // Criar a nova marca com os dados validados
        Cidade::create($validatedData);

        // Retornar uma resposta de sucesso com a marca recém-criada
        return redirect()->route('cidade.index')->with('success', 'Cidade criada com sucesso!');
    }

    public function show() {}

    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos do formulário
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'O nome da cidade é obrigatório.',
        ]);


        // Encontrar a marca pelo ID
        $cidade = Cidade::find($id);

        if (!$cidade) {
            return redirect()->route('cidade.index')->with('error', 'Cidade não encontrada.');
        }

        // Atualizar os dados da marca
        $cidade->name = $request->input('name');

        // Salvar as alterações no banco de dados
        $cidade->save();

        // Redirecionar de volta para a lista de marcas com uma mensagem de sucesso
        return redirect()->route('cidade.index')->with('success', 'Cidade atualizada com sucesso.');
    }

    public function destroy($id)
    {
        try {
            $cidade = Cidade::query()->find($id);
            $cidade->delete();
            return redirect()->route('cidade.index')->with('success', 'Cidade excluida com sucesso.');
        } catch (\Throwable $th) {
            return redirect()->route('cidade.index')->with('error', 'Erro ao excluir');
        }
    }
}
