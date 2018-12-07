<?php

namespace App\Http\Requests\Partner;

use App\Http\Requests\Request;

class SupplierReqInsert extends Request
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'factory_name'      => 'required',
            'factory_address'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'factory_name.required'      => '工厂名称必填',
            'factory_address.required'   => '工厂地址必填',
        ];
    }
}
