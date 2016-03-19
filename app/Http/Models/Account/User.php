<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/20
 * Time: 16:18
 */

namespace App\Http\Models\Account;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $fillable = ['name','mobile','password'];


    public function scopeForNameOrMobile($query,$user_or_mobile)
    {
        return $query->where('name',$user_or_mobile)
            ->orWhere('mobile',$user_or_mobile);
    }
    /*
     * 用户信息
     */
    public function info()
    {
        return $this->hasOne('App\Http\Models\Account\UserInfo','user_id');
    }
    /*
     * 用户组
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_role');
    }
    public function toArray()
    {
        $result = parent::toArray();
        $result['roles'] = $this->roles()->get()->toArray();
        return $result;
    }


}