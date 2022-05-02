<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|between:5,30',
            'author' => 'required|min:2|max:20',
            //'email' => 'bail|required_if:author,mg|email',
            'description' => 'max:200',
            //'is_active' => 'accepted_if:author,mg'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title laukas yra privalomas',
            'title.between' => 'Simboliu kiekis turi buti nuo 5 iki 30',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'is_active' => 'Active'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }
}
