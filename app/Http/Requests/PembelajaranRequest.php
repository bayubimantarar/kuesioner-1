<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelajaranRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'kuesioner' => 'required',
            'deskripsi' => 'required',
            'studi' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'kuesioner.required' => 'Judul kuesioner tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi kuesioner tidak boleh kosong.',
            'studi.required' => 'Silahkan pilih kelas kuliah.'
        ];
    }
}
