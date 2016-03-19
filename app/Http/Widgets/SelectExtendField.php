<?php
/**
 * Created by PhpStorm.
 * User: Tiago
 * Date: 2016/1/13
 * Time: 18:07
 */
namespace App\Http\Widgets;
use Kris\LaravelFormBuilder\Fields\FormField;

class SelectExtendField extends FormField
{
    protected function getTemplate()
    {
        return 'widgets.select_extend';
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
        return $this->js;
    }
    public function getJsContent()
    {
        $this->js_content=<<<JS
        selChanged();
        function selChanged()
        {
            var selId = $('#{$this->getOptions()['select_name']}').val();
            var typeArr = {$this->getOptions()['types']};
            var help_block = {$this->getOptions()['help_block']};
            var content = '{$this->getOptions()['value']['content']}';
            $('#{$this->getOptions()['follow_name']}').attr('type',typeArr[selId]);
            if(help_block[selId])
            {
                $('#follow_block').html('<p>'+help_block[selId]+'</p>');
            }
            else
            {
                $('#follow_block').html('<p></p>');
            }
            if(typeArr[selId] == 'file' && content)
            {
                $('#follow_block').append('<img src="'+content+'"/>');
            }
        }
JS;
        return $this->js_content;
    }
}