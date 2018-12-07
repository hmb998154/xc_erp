<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

abstract class Request extends FormRequest
{
    /**
     * 判断请求用户是否经过认证
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * 重写Illuminate\Foundation\Http\FormRequest的formatErrors方法
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator){
        $error = $validator->errors()->first();
        $arr = ['status' => 2000,'msg' => $error,'data' => ""];
        return $arr;
    }
    
    /**
     * 重写Illuminate\Foundation\Http\FormRequest的response方法
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        
        return _json_response($errors);
    }
}
