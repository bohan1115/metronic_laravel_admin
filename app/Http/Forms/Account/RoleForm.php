<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/29
 * Time: 21:52
 */

namespace App\Http\Forms\Account;


use App\Http\Models\Account\Menu;
use Kris\LaravelFormBuilder\Form;
use App\Http\Widgets\MultiSelectField;
use App\Http\Models\Account\Permission;


class RoleForm extends Form
{
    public function buildForm()
    {
        $this->add('name','text',['label'=>'名称'])
            ->add('display_name','text',['label'=>'显示名称'])
            ->add('description','textarea',['label'=>'简介','attr' => ['cols' => 10]])
            ->add('permissions','multiselect',['label'=>'权限列表',
                'data'=>(new Permission())->getIdAndName()])
            ->add('save','submit',['label'=>'保存'])
            ->add('cancel','reset',['label'=>'取消']);
    }

}