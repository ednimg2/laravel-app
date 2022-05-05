<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:20',
            'description' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            //'title.max' => 'Simboliu skaičius negali viršyti 20',
            'description.required' => 'A description is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Pavadinimas',
        ];
    }
}
