<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 16/3/16
 * Time: 10:23
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $table = 'example';
    protected $fillable = ['name','sn','price','status','description'];
}