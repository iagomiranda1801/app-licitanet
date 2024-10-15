@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Cadastrar Nova Cidade</h1>

    <!-- Exibir mensagens de sucesso -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Formulário de criação de marca -->
    <form action="{{ route('cidade.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nome da Marca" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cod_marca">Código</label>
            <input type="number" name="cod_marca" id="cod_marca" class="form-control" placeholder="Código da Marca" value="{{ old('cod_marca') }}">
            @error('cod_marca')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('cidade.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
