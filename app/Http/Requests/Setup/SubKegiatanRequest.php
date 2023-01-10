<?php

namespace App\Http\Requests\Setup;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubKegiatanRequest extends FormRequest
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
            'kegiatan_id' => ['required', 'exists:kegiatan,id'],
            'kode' => ['required', 'numeric'],
            'nama' => ['required', 'string']
        ];
    }
}
