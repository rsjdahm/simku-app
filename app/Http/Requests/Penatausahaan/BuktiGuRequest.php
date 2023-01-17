<?php

namespace App\Http\Requests\Penatausahaan;

use App\Enums\Penatausahaan\JenisBuktiGu;
use App\Enums\Penatausahaan\MetodePembayaran;
use App\Enums\Penatausahaan\StatusPending;
use App\Enums\Penatausahaan\StatusPosting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BuktiGuRequest extends FormRequest
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
            'belanja_rka_pd_id' => ['required', 'exists:belanja_rka_pd,id'],
            'status_pending' => ['required', new Enum(StatusPending::class)],
            'nomor' => ['required_if:status_pending,' . StatusPending::Normal->value, 'required_if:status,' . StatusPosting::Posting->value, 'nullable', 'string', Rule::unique('bukti_gu', 'nomor')->ignore($this->nomor, 'nomor')],
            'tanggal' => ['required_if:status_pending,' . StatusPending::Normal->value, 'required_if:status,' . StatusPosting::Posting->value, 'nullable', 'date'],
            'uraian' => ['required', 'string'],
            'nilai' => ['required', 'numeric'],
            'metode_pembayaran' => ['required', new Enum(MetodePembayaran::class)],
            'status' => ['required', new Enum(StatusPosting::class)],
            'nama' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'npwp' => ['nullable', 'string'],
            'bank_id' => ['required_if:metode_pembayaran,' . MetodePembayaran::Transfer->value, 'nullable', 'exists:bank,id'],
            'nomor_rekening' => ['required_if:metode_pembayaran,' . MetodePembayaran::Transfer->value, 'nullable', 'string'],
            'jenis' => ['required', new Enum(JenisBuktiGu::class)],
            'tanggal_bayar' => ['required_if:status,' . StatusPosting::Posting->value, 'nullable', 'date']
        ];
    }
}
