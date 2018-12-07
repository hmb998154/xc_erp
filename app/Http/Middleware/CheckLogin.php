<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 检车用户是否登录
 */
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(session()->get('staff_id'))){
             return redirect("/erp/login");
        }
        return $next($request);
    }
}
