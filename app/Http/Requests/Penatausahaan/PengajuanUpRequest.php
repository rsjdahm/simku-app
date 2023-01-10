<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PengajuanUpRequest extends FormRequest
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
            'rek_sub_rincian_objek_id' => ['required', 'exists:rek_sub_rincian_objek,id'],
            'nomor' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'uraian' => ['required', 'string'],
            'nilai' => ['required', 'numeric'],
            'status' => ['required', new Enum(StatusPosting::class)]
        ];
    }
}
