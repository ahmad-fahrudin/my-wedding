<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UndanganRequest extends FormRequest
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
        return [
            'nama_mempelai_1' => 'required|string|max:255',
            'nama_mempelai_2' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'waktu_acara' => 'required|string',
            'tempat' => 'required|string',
            'url_maps' => 'required|url',
            'rekening' => 'nullable|string',
        ];
    }
}
