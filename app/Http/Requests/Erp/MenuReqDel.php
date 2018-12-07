<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class MenuReqDel extends Request
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'menu_id' => 'required|integer|exists:erp_menu,menu_id',
        ];
    }

    public function messages()
    {
        return [
            'menu_id.required' => '菜单id必填',
            'menu_id.integer'  => '菜单id必须是整型',
            'menu_id.exists'   => '菜单id不存在',
        ];
    }
}
