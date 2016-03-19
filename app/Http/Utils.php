<?php

namespace App\Http;
use App\Http\Models\Account\User;
use Illuminate\Support\Facades\Session;
use App\Http\Models\Account\Permission;
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/30
 * Time: 18:07
 * Description: 工具类
 */

trait Utils
{
    private function getPerm($reset=false)
    {
        $user = Session::get('user',null);
        $permssion = Session::get('permssion',null);
        if(!$permssion)
        {
            $permssion = (new Permission())->getPermForUserID($user->id);
            Session::put('permission',$permssion);
        }
        else
        {
            if($reset)
            {
                Session::pull('permission',null);
                $this->getPerm();
            }
        }

        return $permssion;
    }
    /*
     * 查询是否有指定路由权限
     */
    protected function hasPermission($route)
    {
        $permission = $this->getPerm();

        foreach($permission as $value)
        {
            if($route == $value->route_name)
            {
                return true;
            }
        }
        return false;
    }
    public function makePassword($password)
    {
        return sha1($password.env('SALT'));
    }
}