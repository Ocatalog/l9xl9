<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class HunterModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "hunters";
    protected $primaryKey = 'id';
    protected $fillable = [
        'nome_hunter',
        'email_hunter',
        'idade_hunter',
        'altura_hunter',
        'peso_hunter',
        'tipo_hunter',
        'tipo_nen',
        'tipo_sangue',
        'imagem_hunter',
        'serial',
    ];
    public function sendEmailToHunter()
    {
        Mail::to($this->email_hunter)->send(new SendEmail($this));
    }
}
