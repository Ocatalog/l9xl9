<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HunterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return
        [
            'nome_hunter' => 'required|max:50',
            'idade_hunter' => 'required|integer|min:13',
            'altura_hunter' => 'required|numeric|min:1.50|max:2.50',
            'peso_hunter' => 'required|numeric|min:50.00|max:150.00',
            'tipo_hunter' => ['required','max:50', Rule::in(['Hunter Gourmet','Hunter Arqueólogo','Hunter Cientista ou Hunter Técnico',
            'Hunter Selvagem ou Hunter Ambientalista','Hunter Musical','Hunter Treasure','Hunter Lista Negra','Hunter Mercenário',
            'Hunter Medicinal','Hunter Hacker','Hunter Cabeça','Hunter de Informação','Hunter Jackspot','Hunter Vírus','Hunter da Juventudade e Beleza',
            'Hunter Terrorista','Hunter de Venenos','Hunter Caçador','Hunter Paleógrafo','Hunter Perdido','Hunter Provisório','Hunter Temporário'])],
            'tipo_nen' => ['required','max:30', Rule::in(['Reforço','Emissão','Transformação','Manipulação','Materialização','Especialização'])],
            'tipo_sangue' => ['required','max:3', Rule::in(['A+','A-','B+','B-','AB+','AB-','O+','O-'])],
            'imagem_hunter' => 'required|max:1024|image',
            'serial' => 'unique:hunters,serial',
        ];
    }
    // Customizing messages rules
    public function messages()
    {
        return [
            'nome_hunter.required' => 'É obrigatório definir o nome do Hunter.',
            'nome_hunter.max' => 'O nome do Hunter deve conter no máximo 50 caracteres.',
            'idade_hunter.required' => 'É obrigatório definir a idade do Hunter.',
            'idade_hunter.integer' => 'A idade do Hunter precisa ser um valor inteiro.',
            'idade_hunter.min' => 'A idade mínima do Hunter precisa ser de 13 anos de idade.',
            'altura_hunter.required' => 'É obrigatório definir a altura do Hunter.',
            'altura_hunter.numeric' => 'A altura do Hunter precisa ser um valor numérico.',
            'altura_hunter.min' => 'A altura mínima do Hunter precisa ser de 1.50 m.',
            'altura_hunter.max' => 'A altura máxima do Hunter precisa ser de 2.50 m.',
            'peso_hunter.required' => 'É obrigatório definir o peso do Hunter.',
            'peso_hunter.numeric' => 'O peso do Hunter precisa ser um valor numérico.',
            'peso_hunter.min' => 'O peso mínimo do Hunter precisa ser de 50 kg.',
            'peso_hunter.max' => 'O peso máximo do Hunter precisa ser de 150.00 kg.',
            'tipo_hunter.required' => 'É obrigatório definir o tipo de Hunter.',
            'tipo_hunter.max' => 'O tipo do Hunter deve conter no máximo 50 caracteres.',
            'tipo_hunter.in' => 'Tipo de Hunter desconhecido, escolha uma das opções válidas.',
            'tipo_nen.required' => 'É obrigatório definir o tipo de Nen do Hunter.',
            'tipo_nen.max' => 'O tipo de Nen do Hunter deve conter no máximo 50 caracteres.',
            'tipo_nen.in' => 'Tipo de Nen desconhecido, escolha uma das opções válidas.',
            'tipo_sangue.required' => 'É obrigatório definir o tipo sanguíneo do Hunter.',
            'tipo_sangue.max' => 'O tipo sanguíneo do Hunter deve conter no máximo 3 caracteres.',
            'tipo_sangue.in' => 'Tipo sanguíneo desconhecido, escolha uma das opções válidas.',
            'imagem_hunter.required' => 'É obrigatório inserir a imagem do Hunter.',
            'imagem_hunter.max' => 'A imagem do Hunter deve ocupar no máximo 1024KB (1MB) de espaço.',
            'imagem_hunter.image' => 'As extensões permitidas para a imagem são: .jpg, .jpeg, .png, .bmp, .gif, .svg e .webp.',
            'serial.unique' => 'Houve uma repetição na aleatoriedade do serial.',
        ];
    }
}
