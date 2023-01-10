<?php

namespace App\Http\Requests\Anggaran;

use App\Enums\Anggaran\StatusRkaPdEnum;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class RkaPdRequest extends FormRequest
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
            'sub_unit_kerja_id' => ['required', 'exists:sub_unit_kerja,id'],
            'nomor' => ['required', 'string'],
            'uraian' => ['required', 'string'],
            'status' => ['required', new Enum(StatusRkaPdEnum::class)],
            'tanggal' => ['required', 'date'],
            'pagu_pendapatan' => ['required', 'numeric'],
            'pagu_pengeluaran' => ['required', 'numeric'],
            'pagu_pembiayaan' => ['required', 'numeric'],
        ];
    }
}
