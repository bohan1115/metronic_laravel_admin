<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/30
 * Time: 23:14
 */
namespace App\Http\Widgets;

use Kris\LaravelFormBuilder\Fields\FormField;

class TagesInputField extends FormField
{
    protected function getTemplate()
    {
        return 'widgets.tagesinput';
    }
    public function getCss()
    {
        $this->css[] = '/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css';
        return $this->css;
    }
    public function getJs()
    {
        $this->js[] = '/assets/global/plugins/jquery-tags-input/jquery.tagsinput.js';
        return $this->js;
    }
    public function getJsContent()
    {
    	$this->js_content = <<<JS
    	   $(function(){
                var id=$(".tags").attr('id');
                $("#"+id).tagsInput({width:'auto',height:'auto'});
            })
JS;
        return $this->js_content;
    }

}