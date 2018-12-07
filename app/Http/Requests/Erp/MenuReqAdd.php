<?php

namespace App\Http\Requests\Erp;

use App\Http\Requests\Request;

class MenuReqAdd extends Request
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
            'menu_name' => 'required|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
        ];
    }

    public function messages()
    {

        return [
            'menu_name.required' => '菜单名称必填',
            'menu_name.regex'    => '菜单名称格式不对必填',

        ];
    }
}
