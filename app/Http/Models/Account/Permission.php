<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/20
 * Time: 16:19
 */

namespace App\Http\Models\Account;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{

    protected $table = 'permission';

    protected $fillable = ['name','display_name','route_name','show'];

    public function menu()
    {
        return $this->belongsTo('App\Http\Models\Account\Menu','menu_id');
    }
    public function getIdAndName()
    {
        $result = [];
        foreach($this->all('id','name') as $value)
        {
            $result[$value->id] = $value->name;
        }
        return $result;
    }

    public function getPermForUserID($user_id)
    {
        $result = DB::select("select * from permission where id
                  in( select permission_id from role_permission where role_id
                  in (select role_id from user_role where user_id={$user_id}))");
        return $result;

    }

}