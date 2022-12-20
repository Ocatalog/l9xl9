@extends('templates.template_hunter')
@section('title', 'Cadastrar Hunter')
@section('content')
    <div class="contained">
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Cadastrar Hunter
                            <a href="{{ url("/") }}" class="btn btn-secondary float-end" title="Retornar listagem"><i class="fa fa-arrow-left"></i>&nbsp;Retornar listagem</a>
                        </h4>
                    </div>
                </div>
                <br>
                <div class="card-body">
                    <!-- Errors Validation Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Form -->
                    <form action="{{ url("create") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form_group">
                            <div class="form_group">
                                <div for="nome_hunter">Nome:
                                    <input type="text" class="form-control" name="nome_hunter" placeholder="Digite o nome do Hunter" maxlength="50" value="{{ old('nome_hunter') }}">
                                </div>
                            </div>
                            <br>
                            <div class="form_group">
                                <div for="idade_hunter">Idade:
                                    <input type="text" class="form-control" name="idade_hunter" placeholder="Digite a idade do Hunter" onkeypress="$(this).mask('00', {reverse: true});" value="{{ old('idade_hunter') }}">
                                </div>
                            </div>
                            <br>
                            <div class="form_group">
                                <div for="altura_hunter">Altura:
                                    <input type="text" class="form-control" name="altura_hunter" placeholder="Digite a altura do Hunter"onkeypress="$(this).mask('0.00', {reverse: true});" value="{{ old('altura_hunter') }}">
                                </div>
                            </div>
                            <br>
                            <div class="form_group">
                                <div for="peso_hunter">Peso:
                                    <input type="text" class="form-control" name="peso_hunter" placeholder="Digite o peso do Hunter" onkeypress="$(this).mask('000.00', {reverse: true});" value="{{ old('peso_hunter') }}">
                                </div>
                            </div>
                            <br>
                            <div class="form_group">
                                <div for="tipo_hunter">Tipo de Hunter:
                                    <select class="form-control" name="tipo_hunter">
                                        <option {{ old('tipo_hunter') == '' ? 'selected' : ''}} value="">Defina o tipo de Hunter</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Gourmet' ? 'selected' : ''}} value="Hunter Gourmet">Hunter Gourmet</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Arqueólogo' ? 'selected' : ''}} value="Hunter Arqueólogo">Hunter Arqueólogo</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Cientista ou Hunter Técnico' ? 'selected' : ''}} value="Hunter Cientista ou Hunter Técnico">Hunter Cientista ou Hunter Técnico</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Selvagem ou Hunter Ambientalista' ? 'selected' : ''}} value="Hunter Selvagem ou Hunter Ambientalista">Hunter Selvagem ou Hunter Ambientalista</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Musical' ? 'selected' : ''}} value="Hunter Musical">Hunter Musical</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Treasure' ? 'selected' : ''}} value="Hunter Treasure">Hunter Treasure</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Lista Negra' ? 'selected' : ''}} value="Hunter Lista Negra">Hunter Lista Negra</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Mercenário' ? 'selected' : ''}} value="Hunter Mercenário">Hunter Mercenário</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Medicinal' ? 'selected' : ''}} value="Hunter Medicinal">Hunter Medicinal</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Hacker' ? 'selected' : ''}} value="Hunter Hacker">Hunter Hacker</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Cabeça' ? 'selected' : ''}} value="Hunter Cabeça">Hunter Cabeça</option>
                                        <option {{ old('tipo_hunter') == 'Hunter de Informação' ? 'selected' : ''}} value="Hunter de Informação">Hunter de Informação</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Jackspot' ? 'selected' : ''}} value="Hunter Jackspot">Hunter Jackspot</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Vírus' ? 'selected' : ''}} value="Hunter Vírus">Hunter Vírus</option>
                                        <option {{ old('tipo_hunter') == 'Hunter da Juventudade e Beleza' ? 'selected' : ''}} value="Hunter da Juventudade e Beleza">Hunter da Juventudade e Beleza</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Terrorista' ? 'selected' : ''}} value="Hunter Terrorista">Hunter Terrorista</option>
                                        <option {{ old('tipo_hunter') == 'Hunter de Venenos' ? 'selected' : ''}} value="Hunter de Venenos">Hunter de Venenos</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Caçador' ? 'selected' : ''}} value="Hunter Caçador">Hunter Caçador</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Paleógrafo' ? 'selected' : ''}} value="Hunter Paleógrafo">Hunter Paleógrafo</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Perdido' ? 'selected' : ''}} value="Hunter Perdido">Hunter Perdido</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Provisório' ? 'selected' : ''}} value="Hunter Provisório">Hunter Provisório</option>
                                        <option {{ old('tipo_hunter') == 'Hunter Temporário' ? 'selected' : ''}} value="Hunter Temporário">Hunter Temporário</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form_group">
                                <div for="tipo_nen">Tipo de Nen:
                                    <select class="form-control" name="tipo_nen">
                                        <option {{ old('tipo_nen') == '' ? 'selected' : ''}} value="">Defina o tipo de Nen</option>
                                        <option {{ old('tipo_nen') == 'Reforço' ? 'selected' : ''}} value="Reforço">Reforço</option>
                                        <option {{ old('tipo_nen') == 'Emissão' ? 'selected' : ''}} value="Emissão">Emissão</option>
                                        <option {{ old('tipo_nen') == 'Transformação' ? 'selected' : ''}} value="Transformação">Transformação</option>
                                        <option {{ old('tipo_nen') == 'Manipulação' ? 'selected' : ''}} value="Manipulação">Manipulação</option>
                                        <option {{ old('tipo_nen') == 'Materialização' ? 'selected' : ''}} value="Materialização">Materialização</option>
                                        <option {{ old('tipo_nen') == 'Especialização' ? 'selected' : ''}} value="Especialização">Especialização</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form_group">
                                <div for="tipo_sangue">Tipo sanguíneo:
                                    <select class="form-control" name="tipo_sangue">
                                        <option {{ old('tipo_sangue') == '' ? 'selected' : ''}} value="">Defina o tipo sanguíneo</option>
                                        <option {{ old('tipo_sangue') == 'A+' ? 'selected' : ''}} value="A+">A+</option>
                                        <option {{ old('tipo_sangue') == 'A-' ? 'selected' : ''}} value="A-">A-</option>
                                        <option {{ old('tipo_sangue') == 'B+' ? 'selected' : ''}} value="B+">B+</option>
                                        <option {{ old('tipo_sangue') == 'B-' ? 'selected' : ''}} value="B-">B-</option>
                                        <option {{ old('tipo_sangue') == 'AB+' ? 'selected' : ''}} value="AB+">AB+</option>
                                        <option {{ old('tipo_sangue') == 'AB-' ? 'selected' : ''}} value="AB-">AB-</option>
                                        <option {{ old('tipo_sangue') == 'O+' ? 'selected' : ''}} value="O+">O+</option>
                                        <option {{ old('tipo_sangue') == 'O-' ? 'selected' : ''}} value="O-">O-</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success" title="Cadastrar"><i class="fa fa-plus"></i>&nbsp;Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
