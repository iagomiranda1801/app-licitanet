@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="text-center my-4">Produtos</h1>
    <!-- Botão para criar nova marca -->
    <div class="text-right mb-4">
        <a href="/produtos/create" class="btn btn-success">
            <i class="fas fa-plus"></i> Novo Produto
        </a>
    </div>
    <!-- Filtro para pesquisa -->
    <form action="{{ route('produto.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ request('name') }}">
            </div>
            <!-- Select de Cidades -->
            <div class="col-md-4 mb-2">
                <select class="form-control" id="cod_cidade" name="cod_cidade">
                    <option value="">Selecione uma marca</option>
                    @foreach($cidades as $cidade)
                    <option value="{{ $cidade->id }}" {{ $cidade->cod_cidade == $cidade->id ? 'selected' : '' }}>
                        {{ $cidade->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select class="form-control" id="marca_cod" name="marca_cod">
                    <option value="">Selecione uma marca</option>
                    @foreach($marcas as $marca)
                    <option value="{{ $marca->cod_marca }}" {{ $marca->cod_marca == $marca->id ? 'selected' : '' }}>
                        {{ $marca->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <input type="number" name="vlinit" class="form-control" placeholder="Valor inicial" value="{{ request('vlinit') }}">
            </div>
            <div class="col-md-4 mb-2">
                <input type="number" name="vlFim" class="form-control" placeholder="Valor final" value="{{ request('vlfim') }}">
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="/" class="btn btn-danger">Voltar</a>
        </div>
    </form>
    <!-- Lista de marcas -->
    <div class="row">
        @error('error')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        @forelse ($produtos as $produto)
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Nome do Produto -->
                    <h5 class="card-title">{{ $produto->name }}</h5>

                    <!-- Quantidade em Estoque -->
                    <p class="card-text">Estoque: {{ $produto->estoque }}</p>

                    <!-- Valor do Produto -->
                    <p class="card-text">Valor: R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>

                    <!-- Nome da Cidade -->
                    <p class="card-text">Cidade: {{ $produto->cidade->name }}</p>

                    <!-- Nome da Marca -->
                    <p class="card-text">Marca: {{ $produto->marca->name }}</p>

                    <!-- Descrição -->
                    <p class="card-text">{{ $produto->descricao ?? 'Sem descrição disponível.' }}</p>

                    <!-- Botões para Editar e Excluir -->
                    <div class="d-flex justify-content-between">
                        <!-- Botão para abrir a modal de edição -->
                        <button id="edit-button" type="button" class="btn btn-primary btn-sm edit-button"
                            data-id="{{ $produto->id }}" data-name="{{ $produto->name }}"
                            data-cod_marca="{{ $produto->cod_marca }}"
                            data-descricao="{{ $produto->descricao }}"
                            data-estoque="{{ $produto->estoque }}"
                            data-valor="{{ $produto->valor }}"
                            data-cidade="{{ $produto->cidade->id }}"
                            data-marca="{{ $produto->marca->cod_marca }}">
                            Editar
                        </button>

                        <!-- Botão para excluir o produto -->
                        <button type="submit" data-id="{{ $produto->id }}" class="btn btn-danger btn-sm delete-button">
                            Excluir
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Nenhum produto encontrado.</p>
        </div>
        @endforelse
    </div>
    <h6 class="card-subtitle mb-2 text-muted">Total do valor dos produtos: R${{ $soma }}</h6>
    <h6 class="card-subtitle mb-2 text-muted">Média dos produtos: R$ {{ $media }}</h6>
    <!-- Modal de edição -->
    @if(isset($produto))
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('marca.update', $marca->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Nome do Produto -->
                            <div class="form-group col-md-6">
                                <label for="name">Nome</label>
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
                                <input type="number" name="valor" id="valor" class="form-control" placeholder="Valor do Produto" value="{{ old('valor') }}">
                                @error('valor')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Select de Cidades -->
                            <div class="form-group col-md-6">
                                <label for="cod_cidade">Cidade</label>
                                <select name="cod_cidade" id="cod_cidade_one" class="form-control">
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
                                <select name="marca_cod" id="marca_cod_one" class="form-control">
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
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    $(document).ready(function() {
        $('.edit-button').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var descricao = $(this).data('descricao');
            var estoque = $(this).data('estoque');
            var valor = $(this).data('valor');
            var cidade = $(this).data('cidade');
            var marca = $(this).data('marca');

            $('#name').val(name);
            $('#estoque').val(estoque);
            $('#descricao').val(descricao);
            $('#valor').val(valor);

            $('#cod_cidade').val(cidade);
            $('#marca_cod').val(marca);

            // Percorrer o select e selecionar a opção correta para cidade
            $('#cod_cidade_one option').each(function() {
                if ($(this).val() == cidade) {
                    $(this).prop('selected', true);
                }
            });

            // Percorrer o select e selecionar a opção correta para marca
            $('#marca_cod_one option').each(function() {
                if ($(this).val() == marca) {
                    $(this).prop('selected', true);
                }
            });

            $('#editForm').attr('action', '/produto/' + id);
            $('#editModal').modal('show');
        });

        $('.delete-button').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Esta ação não pode ser desfeita!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/produto/' + id,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log("response", response.data)
                            Swal.fire(
                                'Excluído!',
                                'O produto foi excluído com sucesso.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao tentar excluir o produto.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endsection