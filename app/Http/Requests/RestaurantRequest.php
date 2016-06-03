<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RestaurantRequest extends Request
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
            'title_vi' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'desc_vi' => 'required',
            'content_vi' => 'required'
        ];
    }
}
