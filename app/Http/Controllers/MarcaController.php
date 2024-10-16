<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarcaController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $descricao = $request->input('descricao');
        $cod_marca = $request->input('cod_marca');

        $query = Marca::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($descricao) {
            $query->where('descricao', 'like', '%' . $descricao . '%');
        }

        if ($cod_marca) {
            $query->where('cod_marca', $cod_marca);
        }

        $marcas = $query->get();

        // Retornando para a view 'marcas.index' com as marcas
        return view('pages.index-marca', compact('marcas'));
    }

    public function create()
    {
        return view('pages.marca-create');
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos na requisição
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'cod_marca' => 'required|string|max:50|unique:marcas,cod_marca',
            'descricao' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'O nome da marca é obrigatório.',
            'cod_marca.required' => 'O código da marca é obrigatório.',
            'cod_marca.unique' => 'Esse código de marca já está em uso.',
            'descricao.max' => 'A descrição deve ter no máximo 1000 caracteres.'
        ]);

        // Criar a nova marca com os dados validados
        Marca::create($validatedData);

        // Retornar uma resposta de sucesso com a marca recém-criada
        return redirect()->route('marca.index')->with('success', 'Marca criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'cod_marca' => [
                'required',
                'string',
                'max:50',
                Rule::unique('marcas')->ignore($id)
            ],
            'descricao' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'O nome da marca é obrigatório.',
            'cod_marca.required' => 'O código da marca é obrigatório.',
            'cod_marca.unique' => 'Esse código de marca já está em uso.',
            'descricao.max' => 'A descrição deve ter no máximo 1000 caracteres.'
        ]);


        // Encontrar a marca pelo ID
        $marca = Marca::find($id);

        if (!$marca) {
            return redirect()->route('cidade.index')->with('error', 'Marca não encontrada.');
        }

        // Atualizar os dados da marca
        $marca->name = $request->input('name');
        $marca->cod_marca = $request->input('cod_marca');
        $marca->descricao = $request->input('descricao');

        // Salvar as alterações no banco de dados
        $marca->save();

        // Redirecionar de volta para a lista de marcas com uma mensagem de sucesso
        return redirect()->route('cidade.index')->with('success', 'Marca atualizada com sucesso.');
    }

    public function destroy($id)
    {

        try {
            $marca = Marca::query()->find($id);
            $marca->delete();
            return redirect()->route('marca.index')->with('success', 'Marca excluida com sucesso.');
        } catch (\Throwable $th) {
            return redirect()->route('marca.index')->with('error', 'Erro ao excluir');
        }
    }
}
