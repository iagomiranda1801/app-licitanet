@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Marcas</h1>

    <!-- Botão para criar nova marca -->
    <div class="text-right mb-4">
        <a href="{{ route('marca.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nova Marca
        </a>
    </div>

    <!-- Filtro para pesquisa -->
    <form action="{{ route('marca.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" name="name" class="form-control" placeholder="Nome da Marca" value="{{ request('name') }}">
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="descricao" class="form-control" placeholder="Descrição" value="{{ request('descricao') }}">
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="cod_marca" class="form-control" placeholder="Código da Marca" value="{{ request('cod_marca') }}">
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- Lista de marcas -->
    <div class="row">
        @forelse ($marcas as $marca)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $marca->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Código: {{ $marca->cod_marca }}</h6>
                        <p class="card-text">{{ $marca->descricao ?? 'Sem descrição disponível.' }}</p>
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
