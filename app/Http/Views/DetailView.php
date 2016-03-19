<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/24
 * Time: 11:09
 */

namespace App\Http\Views;


class DetailView extends BaseView
{
    protected $list_display = [];

    protected $template = 'layouts.detail';
    protected $icon_title = 'fa fa-list-ul';


    public function addCol($label,$field,$type='text',$rel_field='')
    {
        if($rel_field!='')
        {
            $this->list_display[$label] = ['type'=>$type,'field'=>[$field,$rel_field]];
        }
        else {
            $this->list_display[$label] = ['type'=>$type,'field'=>$field];
        }

        return $this;
    }

    public function updateContext(&$values=[])
    {
        $this->context['data_source'] = $this->data_source;
        $this->context['list_display'] = $this->list_display;

        parent::updateContext($values);
    }
}