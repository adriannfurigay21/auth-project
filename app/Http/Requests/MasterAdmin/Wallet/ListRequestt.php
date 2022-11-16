<?php

namespace App\Http\Requests\MasterAdmin\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class ListRequestt extends FormRequest
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
            'status' => 'string',
            'search' => 'string',
            'order' => 'in:asc,desc',
            'limit' => 'integer'
        ];
    }
}
