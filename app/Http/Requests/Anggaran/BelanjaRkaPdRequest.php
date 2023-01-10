<?php

namespace App\Http\Requests\Anggaran;

use App\Enums\Anggaran\StatusRkaPdEnum;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class BelanjaRkaPdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role == UserRole::Admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rka_pd_id' => ['required', 'exists:rka_pd,id'],
            'sub_kegiatan_id' => ['required', 'exists:sub_kegiatan,id'],
            'rek_sub_rincian_objek_id' => ['required', 'exists:rek_sub_rincian_objek,id'],
            'uraian' => ['required', 'string'],
            'harga_satuan' => ['required', 'numeric'],
            'volume' => ['required', 'numeric'],
            'satuan' => ['required', 'string'],
        ];
    }
}
