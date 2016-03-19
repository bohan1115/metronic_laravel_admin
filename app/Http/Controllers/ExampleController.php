<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 16/3/16
 * Time: 09:27
 */

namespace App\Http\Controllers;

use App\Http\Models\Example;
use App\Http\Views\AdvancedListView;
use Illuminate\Http\Request;
use App\Http\Views\FormView;
use App\Http\Forms\ExampleForm;

class ExampleController extends Controller
{

    public function exampleAdd(Request $request)
    {
        $form_view = new FormView($request,ExampleForm::class);

        $form_view->setBarTitle('新增数据');
        $form_view->setTopMenu($this->getTopMenu());
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTitle('新增数据');
        $form_view->updateContext();

        if($request->ajax())
        {
            $form = $form_view->getForm();

            $form->validate(['name' => 'required|max:20|unique:example',
                'sn'=>'required|max:20|unique:example',
                'price'=>'numeric|required',
                'status'=>'required']);
            if (!$form->isValid()) {
                return $form->getErrors();
            }
            else {
                $example = new Example();
                if ($example) {
                    $example->name = $request->get('name');
                    $example->sn = $request->get('sn');
                    $example->price = $request->get('price');
                    $example->status = $request->get('status');
                    $example->description = $request->get('description');
                } else {
                    return json_encode(['code' => 900, 'msg' => 'Save Failed!']);
                }
                return json_encode(['code' => 100, 'msg' => 'success', 'to' => ex_route('exampleList')]);
            }
        }

        return $form_view->render();

    }
    public function exampleList(Request $request)
    {
        $list = new AdvancedListView($request);
        $list->setTitle('组列表');
        $list->setBarTitle('组列表');
        $list->addCol('名称','name')
            ->addCol('SN','sn',['type'=>'render','content'=>function($row){
                return '<a href="'.ex_route('exampleUpdate').'?id='.$row->id.'">'.$row->sn.'</a>';
            }])
            ->addCol('价格','price')
            ->addCol('虚拟列','virtual_col',['type'=>'virtual','content'=>function($row){
                return '虚拟列';
            }]);

        $list->searchForm()->add('name','text',['label'=>'名称:']);

        $list->setDataSource(Example::all());
        $list->setLeftMenu($this->getLeftMenu());
        $list->setTopMenu($this->getTopMenu());
        $list->updateContext();

        return $list->render();
    }
    public function exampleUpdate(Request $request)
    {
        $id = $request->get('id');
        $example = Example::findOrFail($id);

        $form_view = new FormView($request,ExampleForm::class);
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTopMenu($this->getTopMenu());
        $form_view->setTitle('更新 '.$example->name);
        $form_view->setBarTitle('更新 '.$example->name);

        if($request->ajax())
        {
            $form = $form_view->getForm();
            $form->validate([
                'name'=>'required|max:30',
                'sn'=>'required',
                'price'=>'required',
                'status'=>'required'
            ]);
            if(!$form->isValid())
            {
                return $form->getErrors();
            }
            else{
                $example->name = $request->get('name');
                $example->sn = $request->get('sn');
                $example->price = $request->get('price');
                $example->status = $request->get('status');
                $example->description = $request->get('description');
                $example->save();
                return json_encode(['code'=>100,'msg'=>'success','to'=>ex_route('exampleList')]);
            }
        }
        else
        {
            $form_view->getForm()->addData($example->toArray());
            $form_view->getForm()->rebuildForm();
        }
        $form_view->updateContext();
        return $form_view->render();
    }

    public function exampleDelete(Request $request)
    {
        $id = $request->get('id');
        $example = Example::findOrFail($id);
        if($request->method() == 'POST')
        {
            $example->delete();
            return redirect()->route('exampleList');
        }
        $delete = new DeleteView($request);
        $delete->setTitle('删除 '.$example->name);
        $delete->setBarTitle('删除 '.$example->name);
        $delete->setLeftMenu($this->getLeftMenu());
        $delete->setTopMenu($this->getTopMenu());
        $delete->setDoneRoute('exampleList');
        $delete->updateContext();
        return $delete->render();
    }
}