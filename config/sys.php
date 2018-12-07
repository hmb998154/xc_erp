<?php

return [
    // 不需要验证登录的功能，元素为对应功能的uri字符串
    'unwanted_login' => [
        'login/verifyCode',
        'login/in',
        'login/out',
    ],
    // 不需要验证权限的功能，元素为对应功能的uri字符串
    'access_public' => [
        '/erp/verifyCode',
        '/erp/in',
        '/erp/out',
    ],
    // 系统验证不通过时的状态码
    'sys_error' => [
        'permission_denied' => ['status' => 1000, 'msg' => '权限不足'],
        'un_login' => ['status' => 1001, 'msg' => '需要登录'],
        'form_valid_denied' => ['status' => 1002, 'msg' => '表单验证不通过'],
        'sign_valid_denied' => ['status' => 1003, 'msg' => '签名验证不通过'],
    ],
    // app端签名用auth_key
    'app_auth_key' => env('APP_AUTH_KEY', 'abcdeft12345'),
    // 不需要跨域处理的路由
    'unwanted_enable_cross' => [
        'inventory/gps/template',
    ]
];