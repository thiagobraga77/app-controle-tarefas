@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Tarefas
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('tarefa.create') }}" class="mr-3">Novo</a>
                                <a href="{{ route('tarefa.exportacao', ['extensao' => 'xlsx'])}}" class="mr-3">XLSX</a>
                                <a href="{{ route('tarefa.exportacao', ['extensao' => 'csv']) }}">CSV</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tarefa</th>
                                    <th>Data limite de conclusão</th>
                                    <th colspan="2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarefas as $t)
                                    <tr>
                                        <td>{{ $t->id }}</td>
                                        <td>{{ $t->tarefa }}</td>
                                        <td>{{ date('d/m/Y', strtotime($t->data_limite_conclusao)) }}</td>

                                        <td>
                                            <a href="{{ route('tarefa.edit', $t->id) }}">Editar</a>
                                        </td>

                                        <td>
                                            <form id="form_{{ $t->id }}" method="POST"
                                                action="{{ route('tarefa.destroy', ['tarefa' => $t->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                            </form>

                                            <a href="#"
                                                onclick="event.preventDefault(); document.getElementById('form_{{ $t->id }}').submit();">
                                                Excluir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $tarefas->previousPageUrl() }}">Voltar</a>
                                </li>

                                @for ($i = 1; $i <= $tarefas->lastPage(); $i++)
                                    <li class="page-item {{ $tarefas->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $tarefas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <li class="page-item">
                                    <a class="page-link" href="{{ $tarefas->nextPageUrl() }}">Avançar</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
