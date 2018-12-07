<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class RoleDelReq extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => '角色ID必填',
            'role_id.integer' => '角色名ID必须为数字',
        ];
    }
}
