<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class Sp2dRequest extends FormRequest
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
            'spm_id' => ['required', 'exists:spm,id'],
            'nomor' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', new Enum(StatusPosting::class)],
            'nomor_cek' => ['required', 'string'],
        ];
    }
}
