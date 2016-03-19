<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/21
 * Time: 16:33
 */

namespace App\Http\Models\Account;


use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menu';
    protected $fillable = ['prefix','name','icon'];

    public function permission()
    {
        return $this->hasMany('App\Http\Models\Account\Permission','menu_id');
    }
    /*
     * 获取id:name 数组
     */
    public function getIdAndName()
    {
        $result = [];
        foreach($this->all('id','name') as $value)
        {
            $result[$value->id] = $value->name;
        }
        return $result;
    }
    /*
     * 获取菜单
     */

}