<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/30
 * Time: 23:14
 */

namespace App\Http\Widgets;


use Kris\LaravelFormBuilder\Fields\FormField;

class MultiSelectField extends FormField
{
    protected function getTemplate()
    {
        return 'widgets.multiselect';
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['somedata'] = 'This is some data for view';

        return parent::render($options, $showLabel, $showField, $showError);
    }
    public function getCss()
    {
        $this->css[] = '/assets/global/plugins/bootstrap-select/bootstrap-select.min.css';
        $this->css[] = '/assets/global/plugins/select2/select2.css';
        $this->css[] = '/assets/global/plugins/jquery-multi-select/css/multi-select.css';
        return $this->css;
    }
    public function getJs()
    {
        $this->js[] = '/assets/global/plugins/bootstrap-select/bootstrap-select.min.js';
        $this->js[] = '/assets/global/plugins/select2/select2.min.js';
        $this->js[] = '/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js';

        return $this->js;
    }
    public function getJsContent()
    {
        $this->js_content = <<<JS
    $('#{$this->getRealName()}').multiSelect();
			//计算全部添加和全部删除的位置
			var btnWidth = $('.allchoice').outerWidth();
			var selectableWidth = $('.ms-selectable').outerWidth();
			var btnLeft = (selectableWidth - btnWidth) / 2;
			var btnRight = btnLeft + 37;
			$('.allchoice').css({
				"margin-top": "10px",
				"margin-left": btnLeft,
				"margin-right": btnRight
			});
			$('.alldelete').css({
				"margin-top": "10px",
				"margin-left": btnLeft
			});

			//点击全部添加
			$('.allchoice').click(function() {
				$('#ms-{$this->getRealName()} .ms-list').eq(0).find('li').addClass('ms-hover ms-selected').css("display", "none");
				$('#ms-{$this->getRealName()} .ms-list').eq(1).find('li').addClass('ms-selected').css("display", "block");
				//点击左边的按钮的时候改变两个按钮的状态
				$(this).attr("disabled","disabled").removeClass('btn-primary');
				$('.alldelete').removeAttr("disabled").addClass('btn-primary');
			});
			//点击全部删除
			$('.alldelete').click(function() {
				$('#ms-{$this->getRealName()} .ms-list').eq(1).find('li').removeClass('ms-hover ms-selected').css("display", "none");
				$('#ms-{$this->getRealName()} .ms-list').eq(0).find('li').removeClass('ms-hover ms-selected').css("display", "block");
				//点击左边的按钮的时候改变两个按钮的状态
				$(this).attr("disabled","disabled").removeClass('btn-primary');
				$('.allchoice').removeAttr("disabled").addClass('btn-primary');
			});
			//初始化右边的按钮不能点
			$('.alldelete').attr("disabled","disabled").removeClass('btn-primary');
			//点击左边的内容的时候改变两个按钮的状态
			$(document).on("dblclick",".ms-elem-selectable",function(){
				if($('.ms-selectable').find('.ms-selected').length == $('.ms-elem-selectable').length ){
					$('.allchoice').attr("disabled","disabled").removeClass('btn-primary');
				}
				$('.alldelete').removeAttr("disabled").addClass('btn-primary');
			});
			//点击左边的内容的时候改变两个按钮的状态
			$(document).on("dblclick",".ms-elem-selection",function(){
				if($('.ms-selection').find('.ms-selected').length == $('.ms-elem-selection').length ){
					$('.alldelete').attr("disabled","disabled").removeClass('btn-primary');
				}
				$('.allchoice').removeAttr("disabled").addClass('btn-primary');
			});

JS;
        return $this->js_content;
    }

}