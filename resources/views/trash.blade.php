@extends('templates.template_hunter')
@section('title', 'Hunters apagados')
@section('content')
    <!-- Alert status -->
    @include('components.alert-component')
    <!-- Form -->
    <div class="contained">
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Hunters apagados
                            <a href="{{ url("/") }}" class="btn btn-secondary float-end" title="Retornar listagem"><i class="fa fa-arrow-left"></i>&nbsp;Retornar listagem</a>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" style="width:100%" id="search_hunter">
                        <thead>
                            <tr>
                                <th title="ID">ID</th>
                                <th title="Avatar">Avatar</th>
                                <th title="Nome">Nome</th>
                                <th title="Idade">Idade</th>
                                <th title="Altura">Altura</th>
                                <th title="Peso">Peso</th>
                                <th title="Tipo de hunter">Tipo de Hunter</th>
                                <th title="Tipo de nen">Tipo de Nen</th>
                                <th title="Tipo sanguíneo">Tipo sanguíneo</th>
                                <th title="Serial">Serial</th>
                                {{-- <th title="Propriedades">Propriedades</th> --}}
                                <th title="Data de cadastro">Data de exclusão</th>
                                <th title="Ações">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hunter as $hxh)
                                <tr>
                                    <td title="{{ $hxh->id }}">{{ $hxh->id }}</td>
                                    <td>
                                        @foreach (explode(',', $hxh->imagem_hunter) as $imagem)
                                            <img src="{{ asset('trashed/avatars/'.$hxh->id.'/'.$imagem) }}" height=100 width=100 style="margin: 5px">
                                        @endforeach
                                    </td>
                                    <td title="{{ $hxh->nome_hunter }}">{{ $hxh->nome_hunter }}</td>
                                    <td title="{{ $hxh->idade_hunter }}">{{ $hxh->idade_hunter }}</td>
                                    <td title="{{ $hxh->altura_hunter }} m">{{ $hxh->altura_hunter }} m</td>
                                    <td title="{{ $hxh->peso_hunter }} kg">{{ $hxh->peso_hunter }} kg</td>
                                    <td title="{{ $hxh->tipo_hunter }}">{{ $hxh->tipo_hunter }}</td>
                                    <td title="{{ $hxh->tipo_nen }}">{{ $hxh->tipo_nen }}</td>
                                    <td title="{{ $hxh->tipo_sangue }}">{{ $hxh->tipo_sangue }}</td>
                                    <td title="{{ $hxh->serial }}">{{ $hxh->serial }}</td>
                                    {{-- <td> {{ json_encode($hxh->propriedades, JSON_UNESCAPED_UNICODE) }}</td> --}}
                                    <td title="{{ \Carbon\Carbon::parse($hxh->deleted_at)->format('d/m/Y H:i:s')}}">{{ \Carbon\Carbon::parse($hxh->deleted_at)->format('d/m/Y H:i:s')}}</td>
                                    <td>
                                        <form action="{{ url("delete_register/".encrypt($hxh->id)) }}" method="POST">
                                            <a href="{{ url("restore_register/".encrypt($hxh->id)) }}" class="btn btn-primary" title="Restaurar {{ $hxh->nome_hunter }}"><i class="fa fa-arrows-rotate"></i>&nbsp;Restaurar</a>
                                            {{ ' ' }} {{ method_field('DELETE') }} {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger" title="Deletar {{ $hxh->nome_hunter }}"><i class="fa fa-trash"></i>&nbsp;Deletar</button>
                                        </form>
                                    </td>
                                </tr>
	                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
