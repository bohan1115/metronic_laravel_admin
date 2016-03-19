<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/29
 * Time: 22:26
 */

namespace App\Http\Forms\Account;


use App\Http\Models\Account\Menu;
use Kris\LaravelFormBuilder\Form;

class PermissionForm extends Form
{

    public function buildForm()
    {
        $this->add('name','text',['label'=>'名称'])
            ->add('menu_id','select',['label'=>'所属菜单',
                'choices'=>(new Menu())->getIdAndName(),
                //'selected' => 'en',
                'empty_value' => '=== Select ==='
            ])
            ->add('route_name','text',['label'=>'路由'])
            ->add('show','checkbox',['label'=>'是否显示'])
            ->add('description','textarea',['label'=>'简介'])
            ->add('save','submit',['label'=>'保存'])
            ->add('cancel','reset',['label'=>'取消']);
    }
}