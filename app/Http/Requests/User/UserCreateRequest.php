<?php namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UserCreateRequest extends Request {

	/**
	 * Determine if the fan is authorized to make this request.
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
			'password' => 'required|confirmed',
			'password_confirmation' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'gender' => 'required',
			'street' => 'required',
			'zipcode' => 'required',
			'city' => 'required',
			'permission' => 'required',
			'customer_value' => 'required',
			'customer_type' => 'required',
			'language' => 'required'
		];
	}

	/**
	 * Make some changes before sending the request.
	 *
	 * @return array
	 */
	public function inputs()
	{
		$inputs = $this->all();
		$inputs['password'] = bcrypt($inputs['password']);
		return $inputs;
	}

}
