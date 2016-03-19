<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/20
 * Time: 16:18
 */

namespace App\Http\Models\Account;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'role';
    protected $fillable = ['name','display_name','description'];

    //protected $appends = ['test'];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permission','role_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'user_role');
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
    public function toArray()
    {
        $result = parent::toArray();
        $result['permissions'] = $this->permissions()->get()->toArray();
        return $result;
    }

    /*public function getTestAttribute($value)
    {
        var_dump($this->attributes);
        return $this->attributes['test']='<a>'.$value.'</a>';
    }*/

}