<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' =>['sometimes','string','max:255'],
            'email'=>['sometimes','email:dns',Rule::unique('users')->ignore($this->user()->id)],
            'phone'=>['sometimes','regex:/[0-9]{8}/'],
        ];
    }
}
