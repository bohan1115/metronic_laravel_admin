<?php
/**
 * Created by PhpStorm.
 * User: Tiago
 * Date: 2016/1/14
 * Time: 10:30
 */
namespace App\Http\Widgets;
use Kris\LaravelFormBuilder\Fields\FormField;

class EditorField extends FormField
{
    protected function getTemplate()
    {
        return 'widgets.editor';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['somedata'] = 'This is some data for view';
        return parent::render($options, $showLabel, $showField, $showError);
    }
    public function getCss()
    {
        return $this->css;
    }
    public function getJs()
    {
        $this->js[]='/assets/global/plugins/editor/ueditor.config.js';
        $this->js[]='/assets/global/plugins/editor/ueditor.all.min.js';
        $this->js[]='/assets/global/plugins/editor/lang/zh-cn/zh-cn.js';
        return $this->js;
    }
    public function getJsContent()
    {
        $this->js_content=<<<JS
            var ue = UE.getEditor('editor');
            UE.getEditor('editor').execCommand('insertHtml',ue.getContent());

JS;

        return $this->js_content;
    }
}