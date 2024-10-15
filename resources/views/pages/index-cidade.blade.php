@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Cidades</h1>

    <!-- Botão para criar nova marca -->
    <div class="text-right mb-4">
        <a href="{{ route('cidade.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nova Cidade
        </a>
    </div>

    <!-- Filtro para pesquisa -->
    <form action="{{ route('cidade.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ request('name') }}">
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="cod_marca" class="form-control" placeholder="Código" value="{{ request('cod_marca') }}">
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="/" class="btn btn-danger">Voltar</a>
        </div>
    </form>

    <!-- Lista de marcas -->
    <div class="row">
        @forelse ($cidades as $cidade)
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $cidade->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Código: {{ $cidade->cod_cidade }}</h6>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Nenhuma marca encontrada.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection