<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class StoreTruckRequest extends Request {

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
            'brand'         => 'required|min:2',
            'seria'         => 'required|min:1',
            'truck_type_id' => 'required|numeric',
            'country_id'    => 'required|numeric',
            'gos_number'    => 'required|min:3',
            'capacity'      => 'numeric',
            'length'        => 'numeric',
            'width'         => 'numeric',
            'height'        => 'numeric',
        ];
    }

}
