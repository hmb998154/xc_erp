<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class StaffChangeReq extends Request
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
            'old_passwd' => 'required',
            'passwd'     => 'required',
            'qr_passwd'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'old_passwd.required'   => '旧密码必填',
            'passwd.required'       => '新密码必填',
            'qr_passwd.required'    => '确认密码必填',
        ];
    }
}
