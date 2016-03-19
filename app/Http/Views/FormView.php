<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/28
 * Time: 23:24
 */

namespace App\Http\Views;
use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;


class FormView extends BaseView
{
    use FormBuilderTrait;

    protected $form = null;
    protected $template = 'layouts.form';
    protected $icon_title = 'fa fa-plus';

    public function __construct($request,$name,$options=['class' => 'form-horizontal'],$data=[],$template='layouts.form')
    {
        parent::__construct($request);
        $this->form = $this->form($name,$options,$data);
        $this->context['form'] = $this->form;
        $this->template = $template;

    }
    public function &getForm()
    {
        return $this->form;
    }


    public function updateContext(&$values=[])
    {
        $css = [];
        $js = [];
        $js_content = [];
        foreach($this->form->getFields() as $field)
        {
            foreach($field->getCss() as $item)
            {
                $css[] = $item;
            }
            foreach($field->getJs() as $item)
            {
                $js[] = $item;
            }
            $js_content[] = $field->getJsContent();
        }
        $this->context['css'] = $css;
        $this->context['js'] = $js;
        $this->context['js_content'] = $js_content;

        parent::updateContext($values);
    }
}