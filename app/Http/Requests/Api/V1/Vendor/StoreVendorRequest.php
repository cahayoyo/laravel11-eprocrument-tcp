<?php

namespace App\Http\Requests\Api\V1\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:200',
            'tax_number' => 'required|string|max:50|unique:vendors,tax_number',
            'registration_number' => 'required|string|max:50|unique:vendors,registration_number',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'website' => 'nullable|url|max:100',
            'company_phone' => 'required|string|max:20',
            'status' => 'required|in:active,blacklist,inactive'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User harus diisi',
            'user_id.exists' => 'User tidak ditemukan',
            'company_name.required' => 'Nama perusahaan harus diisi',
            'company_name.max' => 'Nama perusahaan maksimal 200 karakter',
            'tax_number.required' => 'NPWP harus diisi',
            'tax_number.unique' => 'NPWP sudah terdaftar',
            'registration_number.required' => 'Nomor registrasi harus diisi',
            'registration_number.unique' => 'Nomor registrasi sudah terdaftar',
            'address.required' => 'Alamat harus diisi',
            'city.required' => 'Kota harus diisi',
            'province.required' => 'Provinsi harus diisi',
            'postal_code.required' => 'Kode pos harus diisi',
            'website.url' => 'Format website tidak valid',
            'company_phone.required' => 'Nomor telepon perusahaan harus diisi',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus active, blacklist, atau inactive'
        ];
    }
}
