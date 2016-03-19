<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/23
 * Time: 11:57
 */

namespace App\Http\Views;



class BaseView
{
    protected $template = 'layouts.base';
    protected $request = null;
    protected $context = [];
    protected $title = '';
    protected $bar_title = '';
    protected $data_source = [];
    protected $left_menu = [];
    protected $top_menu = [];
    protected $icon_title = '';

    //路由名称
    protected $route = '';
    //路由前缀
    protected $prefix = '';

    public function __construct($request)
    {
        $this->request = $request;
    }
    /*public function __call($method,$arg)
    {
        if(strpos($method,'set')==0)
        {
            switch(substr($method,3))
            {
                case 'TitleDescription':
                {
                    $this->context['title_description'] = $arg[0];
                    break;
                }
            }
        }
    }*/
    public function setTitleDescription($title_description)
    {
        $this->context['title_description'] = $title_description;
    }


    public function setTitle($title)
    {
        $this->title = $title;
        $this->context['title'] = $title;
    }
    public function setBarTitle($bar_title)
    {
        $this->bar_title = $bar_title;
        $this->context['bar_title'] = $bar_title;
    }
    public function setDataSource($data_source)
    {
        $this->data_source = $data_source;
    }
    public function setLeftMenu($left_menu)
    {
        $this->left_menu = $left_menu;
        $this->context['left_menu'] = $left_menu;
    }
    public function setTopMenu($top_menu)
    {
        $this->top_menu = $top_menu;
        $this->context['top_menu'] = $top_menu;
    }

    public function setIconTitle($icon_title)
    {
        $this->context['icon_title'] = icon_title;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }
    /*
     * 更新上下文
     */
    public function updateContext(&$values=null)
    {
        $this->context['route']=$this->request->route()->getName();
        $this->context['prefix']=str_replace('/','',$this->request->route()->getPrefix());
        $this->context['icon_title'] = $this->icon_title;

        if($values)
            $this->context = array_merge($this->context,$values);
    }
    /*
     * 输出html
     */
    public function __toString()
    {
        return $this->render();
    }
    public function render()
    {
        return view($this->template, $this->context)->render();
    }

}