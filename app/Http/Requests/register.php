<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
class register extends FormRequest
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
            'name'=>'required|unique:users,name|regex:/^[a-zA-Z0-9- ]*$/',
            'email'=>'required|email|unique:users',
            'password'=> ['required', 'confirmed', 'string', Password::min(8)->letters()->numbers()->symbols()],
        ];
    }
}
