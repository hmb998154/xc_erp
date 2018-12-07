<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class StaffReq extends Request
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
            'staff_name'    => 'required|integer|exists:erp_staff,staff_name',
            'staff_passwd'  => 'required|exists:erp_staff,staff_passwd',
            'code'          => 'required|max:4',
        ];
    }

    public function messages()
    {
        return [
            'staff_name.required'   => '用户名必填',
            'staff_name.integer'    => '用户名必须是整型',
            'staff_name.exists'     => '用户名不存在',

            'staff_passwd.required' => '用户密码必填',
            'staff_passwd.exists'   => '用户密码不存在',

            'code.exists'           => '验证码必填',
            'code.max'              => '验证码最大4位',
        ];
    }
}
