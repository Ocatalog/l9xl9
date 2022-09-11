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
            'idade_hunter' => 'required|numeric',
            'altura_hunter' => 'required|numeric',
            'peso_hunter' => 'required|numeric',
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
            'idade_hunter.numeric' => 'A idade do Hunter precisa ser um valor numérico.',
            'altura_hunter.required' => 'É obrigatório definir a altura do Hunter.',
            'altura_hunter.numeric' => 'A altura do Hunter precisa ser um valor numérico.',
            'peso_hunter.required' => 'É obrigatório definir o peso do Hunter.',
            'peso_hunter.numeric' => 'O peso do Hunter precisa ser um valor numérico.',
            'tipo_hunter.required' => 'É obrigatório definir o tipo de Hunter.',
            'tipo_hunter.max' => 'O tipo do Hunter deve conter no máximo 30 caracteres.',
            'tipo_nen.required' => 'É obrigatório definir o tipo de Nen do Hunter.',
            'tipo_nen.max' => 'O tipo de Nen do Hunter deve conter no máximo 30 caracteres.',
            'tipo_sangue.required' => 'É obrigatório definir o tipo sanguíneo do Hunter.',
            'tipo_sangue.max' => 'O tipo sanguíneo do Hunter deve conter no máximo 3 caracteres.',
        ];
    }
}