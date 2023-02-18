<?php

namespace App\Http\Controllers;

use App\Models\LoggingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class FallbackController extends Controller
{
    public function __invoke()
    {
        $data = Carbon::now()->format('d/m/Y H:i:s');
        $ip_user = request()->ip();
        $mensagem = "Houve um redirecionamento de rota para a Fallback utilizando o IP {$ip_user} em {$data}.";
        Log::channel('logFallbackRoute')->info($mensagem);

        $log = new LoggingModel();
        $log->descricao = $mensagem;
        $log->save();

        return view('fallback');
    }
}
