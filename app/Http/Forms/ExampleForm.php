<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 16/3/16
 * Time: 11:57
 */

namespace App\Http\Forms;


use Kris\LaravelFormBuilder\Form;

class ExampleForm extends Form
{
    public function buildForm()
    {
        $this->add('name','text',['label'=>'名称'])
            ->add('sn','text',['label'=>'SN'])
            ->add('price','text',['label'=>'价格'])
            ->add('status','select',['label'=>'状态','choices'=>['1'=>'上架','2'=>'下架'],'selectd'=>1])
             ->add('pcas','pcas',[
                'label'=>'地区',
            ])
            ->add('tages','tagesinput',[
                'label'=>'标签','data'=>'Tag0,Tag1',
            ])
            ->add('description','textarea',['label'=>'简介'])
            ->add('editor','editor',['label'=>'编辑器'])
            ->add('save','submit',['label'=>'保存'])
            ->add('cancel','reset',['label'=>'取消']);
    }
}
