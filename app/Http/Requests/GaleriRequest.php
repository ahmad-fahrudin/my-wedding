<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GaleriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'undangan_id' => ['required', 'integer', 'exists:undangans,id'],
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:2048'];
        } else {
            $rules['image'] = ['nullable', 'image', 'max:2048'];
        }

        return $rules;
    }
}
