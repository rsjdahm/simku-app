<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SpjGuRequest extends FormRequest
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
            'nomor' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'uraian' => ['required', 'string'],
            'status' => ['required', new Enum(StatusPosting::class)],
        ];
    }
}
