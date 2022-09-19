<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'tipo_hunter' => 'required|max:30',
            'tipo_nen' => 'required|max:30',
            'tipo_sangue' => 'required|max:3',
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
            'tipo_hunter.max' => 'O tipo do Hunter deve conter no máximo 30 caracteres.',
            'tipo_nen.required' => 'É obrigatório definir o tipo de Nen do Hunter.',
            'tipo_nen.max' => 'O tipo de Nen do Hunter deve conter no máximo 30 caracteres.',
            'tipo_sangue.required' => 'É obrigatório definir o tipo sanguíneo do Hunter.',
            'tipo_sangue.max' => 'O tipo sanguíneo do Hunter deve conter no máximo 3 caracteres.',
        ];
    }
}