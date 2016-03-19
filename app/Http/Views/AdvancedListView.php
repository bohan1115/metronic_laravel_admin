<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/24
 * Time: 11:07
 */

namespace App\Http\Views;

use Kris\LaravelFormBuilder\Facades\FormBuilder;
use Yajra\Datatables\Datatables;

class AdvancedListView extends BaseView
{

    protected $list_display = [];
    protected $order_by = [];
    protected $icon_title = 'fa fa-list';

    protected $search_form = null;




    /*
     * 导出文件类型
     */
    protected $export_type = ['csv','excel'];
    /*
     * copy 快捷方式
     */
    protected $copy = true;
    /*
     * 打印快捷方式
     */
    protected $print = true;

    //删除，修改，详情动作
    protected $action = [];

    protected $template = 'layouts.advanced_list';

    public function delete($route)
    {
        $this->action['delete'] = $route;
    }
    public function update($route)
    {
        $this->action['update'] = $route;
    }
    public function detail($route)
    {
        $this->action['detail'] = $route;
    }

    public function &searchForm()
    {
        if(!$this->search_form)
        {
            $this->search_form = FormBuilder::plain();
            $this->context['search_form'] = $this->search_form;
            $this->search_form->add('save','submit',['label'=>'搜索']);
        }
        return $this->search_form;
    }
    /*
     * 支持文件类型:pdf,excel,csv
     */
    public function setExportType($types = [])
    {
        if($types)
            array_merge($this->export_type,$types);
    }
    /*
     * attr = ['type'=>'normal','content'=>'content']
     * type = normal,render,virtual
     */
    public function addCol($label,$field,$attr = ['type'=>'normal','sort'=>true])
    {
        $this->list_display[$field] = array_merge(['label' => $label], $attr);
        return $this;
    }

    public function updateContext(&$values=[])
    {
        $this->context['list_display'] = $this->list_display;
        $this->context['export_type'] = $this->export_type;
        $this->context['copy'] = $this->copy;
        $this->context['print'] = $this->print;
        $this->context['action'] = $this->action;

        parent::updateContext($values);
    }
    public function render()
    {
        if($this->request->ajax())
        {
            $data_table = Datatables::of($this->data_source);

            foreach($this->list_display as $field=>$value)
            {
                switch($value['type'])
                {
                    case 'normal':
                    {
                        break;
                    }
                    case 'virtual':
                    {
                        $data_table->addColumn($field,$value['content']);
                        break;
                    }
                    case 'render':
                    {
                        $data_table->editColumn($field,$value['content']);
                        break;
                    }
                    default:{}
                }
            }
            if($this->action) {
                $data_table->addColumn('action', function ($row) {
                    $str = '';
                    if (array_key_exists('update', $this->action)) {

                        $str = '<a href="' . ex_route($this->action['update']) . '?id=' . $row['id'] . '" class="btn btn-sm green"><i class="fa fa-edit"></i></a>';
                    }

                    if (array_has($this->action, 'delete')) {
                        $str .= '<a href="'. ex_route($this->action['delete']) . '?id=' . $row->id . '" class="btn  btn-sm red"><i class="fa fa-trash-o"></i>';
                    }

                    if (array_has($this->action, 'detail')) {

                        $str .= '<a href="'.ex_route($this->action['detail']) . '?id=' . $row->id . '" class="btn btn-sm blue"><i class="fa fa-list-alt"></i></a>';
                    }

                    return $str;
                });
            }

            return $data_table->make(true);
        }
        else {
            return parent::render();
        }
    }
}