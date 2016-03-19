<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/12/2
 * Time: 22:08
 * Description:列表页渲染
 */

    if(!function_exists('ex_route'))
    {
        function ex_route($route_name)
        {
            try{
                return route($route_name);
            }
            catch(Exception $e)
            {
                return '#';
            }
        }
    }
    if(!function_exists('render_field'))
    {
        function render_field($type,$value,$attr=[])
        {
            switch($type)
            {
                case 'text':
                    return $value;
                case 'image':
                    return '<img src='.$value.' width="30%" height="30%"/>';
                case 'url':
                {

                    return $value.' <a href="'.$value.'" target="blank">打开</a>';
                }
                case 'male':
                {
                    if($value == 1)
                    {
                        return '男';
                    }
                    else if($value == 2){
                        return '女';
                    }
                    else{
                        return '未知';
                    }

                }

                case 'yes_no':
                {
                    if($value)
                    {
                        return '<button type="button" class="btn btn-success btn-xs">Y</button>';
                    }
                    else
                    {
                        return '<button type="button" class="btn btn-danger btn-xs">N</button>';
                    }
                }

                case 'a':
                {
                    return view('type.a',['data'=>array_add($attr,'field',$value)]);
                }
                default:
                    return var_dump($value);
            }
        }
    }
if(!function_exists('menu_prefix'))
{
    function menu_prefix($prefix)
    {
        $menu = Session::get('menu_prefix',null);
        if($menu)
        {
            if(array_key_exists($prefix,$menu))
                return $menu[$prefix];
            else{
                return '';
            }
        }
        else{
            return '当前项';
        }
    }
}
