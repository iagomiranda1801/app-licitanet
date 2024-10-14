@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Bem-vindo ao Sistema de Gestão</h1>

    <!-- Menu com links para Marcas e Produtos -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="list-group">
                <a href="{{ route('marca.index') }}" class="list-group-item list-group-item-action">
                    <h4 class="mb-1">Gerenciar Marcas</h4>
                    <p>Visualize e gerencie as marcas cadastradas no sistema.</p>
                </a>
                <a href="{{ route('produto.index') }}" class="list-group-item list-group-item-action">
                    <h4 class="mb-1">Gerenciar Produtos</h4>
                    <p>Visualize e gerencie os produtos cadastrados no sistema.</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
