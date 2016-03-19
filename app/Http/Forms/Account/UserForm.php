<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/29
 * Time: 08:56
 */

namespace App\Http\Forms\Account;


use App\Http\Models\Account\Role;
use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $this->add('name','text',['label'=>'用户名'])
            ->add('mobile','text',['label'=>'手机'])
            ->add('password','password',['label'=>'密码',
                'help_block'=>['text'=>"原始密码不会存储到数据库，因此没有办法看到这个用户的密码，但您可以<a href='#'>更改</a>密码。"]])
            ->add('roles','multiselect',['label'=>'组',
                'data'=>(new Role())->getIdAndName(),
                'help_block'=>['text'=>'可用权限组']
                ])
            ->add('description','textarea',['label'=>'用户简介'])
            ->add('save','submit',['label'=>'保存'])
            ->add('cancel','reset',['label'=>'取消']);
    }
}