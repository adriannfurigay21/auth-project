<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
class ReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if(Business::where('user_id') === auth()->user()->id && auth()->user()->type == 'admin' || auth()->user()->type == 'masterAdmin' ) {
        //     return true;
        // }
        // return false;

        return auth()->user()->type == 'admin';

        //return Business::where('user_id', '=', Auth::id())->get() || auth()->user()->type === 'masterAdmin';

        // return Business::where('id', $this->post)
        //     ->where('user_id', $this->user()->id)->exists();
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
