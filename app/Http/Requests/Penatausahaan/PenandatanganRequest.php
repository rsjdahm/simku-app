<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\JabatanPenandatangan;
use App\Enums\Penatausahaan\JenisDokumenDitandatangani;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PenandatanganRequest extends FormRequest
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
            'sub_unit_kerja_id' => ['required', 'exists:sub_unit_kerja,id'],
            'nama' => ['required', 'string'],
            'nip' => ['required', 'string'],
            'jabatan' => ['required', new Enum(JabatanPenandatangan::class)],
        ];
    }
}
