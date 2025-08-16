<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role_id == 1; // Only admin
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'no_hp' => 'required|string|max:15|regex:/^08[0-9]{8,11}$/',
            'jabatan_id' => 'required|exists:jabatan,id',
            'lokasi_id' => 'required|exists:lokasi_penempatan,id',
            'alamat' => 'required|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap harus diisi.',
            'nama.string' => 'Nama lengkap harus berupa teks.',
            'nama.max' => 'Nama lengkap maksimal 255 karakter.',

            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',

            'no_hp.required' => 'No. HP harus diisi.',
            'no_hp.regex' => 'Format no. HP tidak valid. Gunakan format 08xxxxxxxxxx.',
            'no_hp.max' => 'No. HP maksimal 15 karakter.',

            'jabatan_id.required' => 'Jabatan harus dipilih.',
            'jabatan_id.exists' => 'Jabatan tidak valid.',

            'lokasi_id.required' => 'Lokasi penempatan harus dipilih.',
            'lokasi_id.exists' => 'Lokasi penempatan tidak valid.',

            'alamat.required' => 'Alamat lengkap harus diisi.',
            'alamat.max' => 'Alamat maksimal 1000 karakter.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? 1 : 0,
        ]);
    }
}
