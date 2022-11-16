<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return auth()->user()->type == 'masterAdmin' || auth()->user()->type == 'admin';
        return auth()->user()->type == 'admin';
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
