<?php

namespace App\Http\Requests;

use App\Enums\GaleriTypeEnum;
use App\Enums\GaleriCategoryEnum;
use Illuminate\Validation\Rules\Enum;
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
            'undangan_id' => 'required|exists:undangans,id',
            'type' => ['nullable', new Enum(GaleriTypeEnum::class)],
            'category' => ['nullable', new Enum(GaleriCategoryEnum::class)],
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:2048'];
        } else {
            $rules['image'] = ['nullable', 'image', 'max:2048'];
        }

        return $rules;
    }
}
