<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\JenisPengeluaran;
use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SppRequest extends FormRequest
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
            'jenis' => ['required', new Enum(JenisPengeluaran::class)],
            'pengajuan_up_id' => ['required_if:jenis,' . JenisPengeluaran::UP->value, 'nullable'],
            'spj_gu_id' => ['required_if:jenis,' . JenisPengeluaran::GU->value, 'nullable'],
            'belanja_ls_id' => ['required_if:jenis,' . JenisPengeluaran::LS->value, 'nullable'],
            'nomor' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'uraian' => ['required', 'string'],
            'status' => ['required', new Enum(StatusPosting::class)],
        ];
    }
}
