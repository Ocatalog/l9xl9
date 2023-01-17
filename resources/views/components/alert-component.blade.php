@if ($mensagem = Session::get('success_store'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p>{{ $mensagem }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif ($mensagem = Session::get('success_update'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <p>{{ $mensagem }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif ($mensagem = Session::get('success_destroy'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>{{ $mensagem }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif ($mensagem = Session::get('export_pdf_error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p>{{ $mensagem }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
