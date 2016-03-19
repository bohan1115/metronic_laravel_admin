<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/12/27
 * Time: 22:51
 */

namespace Kris\LaravelFormBuilder\Fields;


class MultiSelect extends FormField
{

    protected function getTemplate()
    {
        return 'multi_select';
    }
}