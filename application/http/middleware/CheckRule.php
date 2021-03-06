<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/18
 * Time: 22:00
 */

namespace app\http\middleware;


use app\admin\exception\NoAuthForAccessException;
use app\service\facade\AdminRules;
use app\service\facade\Admins;

class CheckRule
{
    public function handle($request, \Closure $next)
    {
        if (!AdminRules::checkRuleByAdmin(Admins::user(), '/' . $request->pathinfo())) {
            if ($request->isAjax()) {
                throw new NoAuthForAccessException();
            } else {
                exception('您无权访问该功能');
            }
        }
        return $next($request);
    }
}