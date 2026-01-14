<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            // Campos simples
            'report_date'        => ['required', 'date'],
            'instructor_id'      => ['required', 'exists:users,id'],
            'materials_provided' => ['required', 'boolean'],
            'grid_provided'      => ['required', 'boolean'],
            'feedback'           => ['required', 'string'],
            'observations'       => ['nullable', 'string'],

            // Lógica Condicional: Se extra_activities for true (1), a descrição vira 'required'
            'extra_activities'             => ['required', 'boolean'],
            'extra_activities_description' => ['nullable', 'string', 'required_if:extra_activities,1'],

            // ARRAY REPEATER (Atenção aqui aos nomes)
            // Se no formulário o name é "workshops[0][school_class_id]", aqui deve ser "workshops"
            'workshops' => ['required', 'array', 'min:1'], 
            
            // Validando cada item dentro do array workshops
            'workshops.*.school_class_id' => ['required', 'exists:school_classes,id'],
            'workshops.*.time'            => ['required', 'date_format:H:i'], 
            'workshops.*.workshop_theme'  => ['required', 'string', 'max:255'],
        ];
    }

    // Opcional: Personalizar mensagens de erro para o array
    public function messages(): array
    {
        return [
            'workshops.required' => 'É necessário adicionar pelo menos uma turma.',
            'workshops.*.school_class_id.required' => 'Selecione a turma em todas as linhas adicionadas.',
            'workshops.*.time.required' => 'Defina o horário para todas as turmas.',
            'workshops.*.workshop_theme' => 'Defina o tema para todas as turmas.',
            'extra_activities_description.required_if' => 'A descrição é obrigatória quando houver atividade extra.',
        ];
    }
}