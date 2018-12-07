<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class StaffAddReq extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'staff_name' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
            'staff_name'    => 'required',
            'staff_phone'   => 'required|',
            'passwd'        => 'required|',
            'qr_passwd'     => 'required|',
            'role_id'       => 'required|',
        ];
    }

    public function messages()
    {
        return [
            'staff_name.required' => '用户名必填',
            // 'staff_name.regex' => '用户名格式错误',
            'passwd.required'     => '密码必填',
            'qr_passwd.required'  => '确认密码必填',
            'role_id.required'    => '角色必选',
        ];
    }
}
