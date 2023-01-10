<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\JenisPotonganPfk;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PotonganPfkRequest extends FormRequest
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
        return [
            'kode_map' => ['nullable', 'string'],
            'nama' => ['required', 'string'],
            'jenis' => ['required', new Enum(JenisPotonganPfk::class)],
        ];
    }
}
