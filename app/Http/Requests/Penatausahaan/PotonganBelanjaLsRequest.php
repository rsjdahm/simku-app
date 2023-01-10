<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\StatusSetor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PotonganBelanjaLsRequest extends FormRequest
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
            'belanja_ls_id' => ['required', 'exists:belanja_ls,id'],
            'potongan_pfk_id' => ['required', 'exists:potongan_pfk,id'],
            'nilai' => ['required', 'numeric'],
            'nomor_billing' => ['required', 'string'],
            'status' => ['required', new Enum(StatusSetor::class)],
            'nomor_penyetoran' => ['required_if:status,' . StatusSetor::Setor->value, 'nullable', 'string'],
            'tanggal_setor' => ['required_if:status,' . StatusSetor::Setor->value, 'nullable', 'date'],
            'tanggal_buku' => ['required_if:status,' . StatusSetor::Setor->value, 'nullable', 'date'],
        ];
    }
}
