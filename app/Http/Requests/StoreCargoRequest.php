<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Cargo;
use Illuminate\Support\Facades\Auth;

class StoreCargoRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'load' => 'required|min:3',
            'descriptions' => 'required|min:10',
            'from' => 'required',
            'to' => 'required',
            'capacity' => 'numeric',
            'weight' => 'numeric',
            'weight' => 'numeric',
        ];
	}

}
