<?php
/**
 * Created by PhpStorm.
 * User: Tiago
 * Date: 2016/1/13
 * Time: 15:33
 */
namespace App\Http\Widgets;
use Kris\LaravelFormBuilder\Fields\FormField;

class PCASField extends FormField
{
    protected function getTemplate()
    {
        return 'widgets.pcas';
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
        $this->js[]='/assets/admin/pcas/PCASClass.js';
        return $this->js;
    }
    public function getJsContent()
    {
        $this->js_content=<<<JS
        new PCAS("province",
            "city",
            "county"
        );

JS;

        return $this->js_content;
    }
}