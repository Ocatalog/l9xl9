@extends('templates.template_hunter')
@section('title', "E-mail para $nome_hunter")
@section('content')

<table style="border-collapse: collapse; width: 100%; max-width: 600px; margin: 0 auto;">
    <tr>
        <td style="background-color: #f8f8f8; padding: 20px; text-align: center;">
            <h1>Detalhes do Hunter</h1>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px;">
            <p><strong>Nome:</strong> {{ $nome_hunter }}</p>
            <p><strong>Email:</strong> {{ $email_hunter }}</p>
            <p><strong>Idade:</strong> {{ $idade_hunter }}</p>
            <p><strong>Altura:</strong> {{ $altura_hunter }} m</p>
            <p><strong>Peso:</strong> {{ $peso_hunter }} kg</p>
            <p><strong>Tipo:</strong> {{ $tipo_hunter }}</p>
            <p><strong>Nen:</strong> {{ $tipo_nen }}</p>
            <p><strong>Tipo sanguíneo:</strong> {{ $tipo_sangue }}</p>
            <p><strong>Serial:</strong> {{ $serial }}</p>
        </td>
    </tr>
</table>

@endsection
