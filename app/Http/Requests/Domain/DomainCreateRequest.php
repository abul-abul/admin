<?php

namespace App\Http\Requests\Domain;

use App\Http\Requests\Request;

class DomainCreateRequest extends Request
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
            'sub_domain' => 'required|unique:domains',
            'client_id' => 'required',
            'client_secret' => 'required'
        ];
    }
}
