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
            </div>

            <div class="row">
                <!-- Quantidade em Estoque -->
                <div class="form-group col-md-6">
                    <label for="quantidade_estoque">Quantidade em Estoque</label>
                    <input type="number" name="estoque" id="estoque" class="form-control" placeholder="Quantidade em Estoque" value="{{ old('estoque') }}">
                    @error('estoque')
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
                    <label for="cod_cidade">Cidade</label>
                    <select name="cod_cidade" id="cod_cidade" class="form-control">
                        <option value="">Selecione uma cidade</option>
                        @foreach($cidades as $cidade)
                        <option value="{{ $cidade->id }}" {{ old('cod_cidade') == $cidade->id ? 'selected' : '' }}>
                            {{ $cidade->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('cod_cidade')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Select de Marcas -->
                <div class="form-group col-md-6">
                    <label for="marca_cod">Marca</label>
                    <select name="marca_cod" id="marca_cod" class="form-control">
                        <option value="">Selecione uma marca</option>
                        @foreach($marcas as $marca)
                        <option value="{{ $marca->cod_marca }}" {{ old('marca_cod') == $marca->cod_marca ? 'selected' : '' }}>
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