<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/12/28
 * Time: 17:04
 */

namespace App\Http\Views;


class DeleteView extends BaseView
{
    protected $template = 'layouts.delete';
    protected $done_route = '';

    public function setDoneRoute($route)
    {
        $this->done_route = $route;
    }

    public function updateContext(&$values=[])
    {
        $this->context['done_route'] = $this->done_route;
        parent::updateContext($values);
    }
}