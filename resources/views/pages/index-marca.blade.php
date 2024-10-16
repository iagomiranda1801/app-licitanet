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
                <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ request('name') }}">
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
            <a href="/" class="btn btn-danger">Voltar</a>
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
                    <!-- Botões para Editar e Excluir -->
                    <div class="d-flex justify-content-between">
                        <!-- Botão para abrir a modal de edição -->
                        <button id="edit-button" type="button" class="btn btn-primary btn-sm edit-button" data-id="{{ $marca->id }}" data-name="{{ $marca->name }}" data-cod_marca="{{ $marca->cod_marca }}" data-descricao="{{ $marca->descricao }}">
                            Editar
                        </button>
                        <!-- Botão para excluir a marca -->
                        <button id="delete-button" type="submit" data-id="{{ $marca->id }}" class="btn btn-danger btn-sm">
                            Excluir
                        </button>

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Nenhuma marca encontrada.</p>
        </div>
        @endforelse
    </div>

    <!-- Modal de edição -->
    @if(isset($marca))
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Marca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('marca.update', $marca->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="hidden" id="id-id" class="form-control" id="modal-name" name="name">
                            <label for="modal-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="modal-name" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="modal-cod_marca" class="form-label">Código</label>
                            <input type="text" class="form-control" id="modal-cod_marca" name="cod_marca" required>
                            @error('cod_marca')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="modal-descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="modal-descricao" name="descricao" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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
            var codMarca = $(this).data('cod_marca');
            var descricao = $(this).data('descricao');
            console.log("id", id);
            $('#id-id').val(name);
            $('#modal-name').val(name);
            $('#modal-cod_marca').val(codMarca);
            $('#modal-descricao').val(descricao);
            $('#editForm').attr('action', '/marca/' + id);

            $('#editModal').modal('show');
        });

        $('#delete-button').on('click', function() {
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
                        url: '/marca/' + id,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Excluído!',
                                'A marca foi excluída com sucesso.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            console.log("error", response)
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao tentar excluir a marca.',
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