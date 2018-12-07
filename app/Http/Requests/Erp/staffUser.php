<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class StaffUser extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'staff_id' => 'required|integer|exists:erp_staff,staff_id',
            // 'role_id'  => 'required|integer|exists:erp_role,role_id',
        ];
    }

    public function messages()
    {
        return [
            'staff_id.required' => '员工id必填',
            'staff_id.integer'  => '员工id必须是整型',
            'staff_id.exists'   => '员工id不存在',
            'role_id.required'  => '角色id必填',
            'role_id.integer'   => '角色id必须是整型',
            'role_id.exists'    => '角色id不存在',
        ];
    }
}
