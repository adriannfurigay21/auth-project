<?php

namespace App\Http\Requests\MasterAdmin\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class ReadRequestt extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->type == 'masterAdmin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:businesses,id'
        ];
    }
}
