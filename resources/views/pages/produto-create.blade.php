@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Cadastrar Novo Produto</h1>

    <!-- Exibir mensagens de sucesso -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container">

        <!-- Exibir mensagens de sucesso -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Formulário de criação de produto -->
        <form action="{{ route('produto.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Nome do Produto -->
                <div class="form-group col-md-6">
                    <label for="name">Nome do Produto</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome do Produto" value="{{ old('name') }}">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Código da Marca -->
                <div class="form-group col-md-6">
                    <label for="cod_marca">Código</label>
                    <input type="number" name="cod_marca" id="cod_marca" class="form-control" placeholder="Código da Marca" value="{{ old('cod_marca') }}">
                    @error('cod_marca')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Quantidade em Estoque -->
                <div class="form-group col-md-6">
                    <label for="quantidade_estoque">Quantidade em Estoque</label>
                    <input type="number" name="quantidade_estoque" id="quantidade_estoque" class="form-control" placeholder="Quantidade em Estoque" value="{{ old('quantidade_estoque') }}">
                    @error('quantidade_estoque')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Valor do Produto -->
                <div class="form-group col-md-6">
                    <label for="valor">Valor (R$)</label>
                    <input type="text" name="valor" id="valor" class="form-control" placeholder="Valor do Produto" value="{{ old('valor') }}">
                    @error('valor')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <!-- Select de Cidades -->
                <div class="form-group col-md-6">
                    <label for="cidade_id">Cidade</label>
                    <select name="cidade_id" id="cidade_id" class="form-control">
                        <option value="">Selecione uma cidade</option>
                        @foreach($cidades as $cidade)
                        <option value="{{ $cidade->id }}" {{ old('cidade_id') == $cidade->id ? 'selected' : '' }}>
                            {{ $cidade->nome }}
                        </option>
                        @endforeach
                    </select>
                    @error('cidade_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Select de Marcas -->
                <div class="form-group col-md-6">
                    <label for="marca_id">Marca</label>
                    <select name="marca_id" id="marca_id" class="form-control">
                        <option value="">Selecione uma marca</option>
                        @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                            {{ $marca->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('marca_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Descrição do Produto (ocupa toda a linha) -->
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="3" placeholder="Descrição do Produto">{{ old('descricao') }}</textarea>
                    @error('descricao')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('produto.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
    @endsection