<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class StaffDelReq extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'staff_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'staff_id.required' => '用户ID',
            'staff_id.integer'  => '用户名ID必须为数字',
        ];
    }
}
