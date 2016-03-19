<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/17
 * Time: 21:30
 * Description: 用户，权限，认证
 */

namespace App\Http\Controllers;
use App\Http\Models\Account\Permission;
use App\Http\Models\Account\Role;
use App\Http\Models\Account\User;
use App\Http\Models\Account\Menu;
use App\Http\Utils;
use App\Http\Views\AdvancedListView;
use App\Http\Views\BaseView;
use App\Http\Views\DetailView;
use App\Http\Views\FormView;
use App\Http\Views\ListView;
use App\Http\Views\DeleteView;
use Log;
use Illuminate\Http\Request;
use App\Http\Forms\Account\UserForm;
use App\Http\Forms\Account\RoleForm;
use App\Http\Forms\Account\PermissionForm;
use Session;

use DB;
class AccountController extends Controller
{
    use Utils;
    /*
     * 登录
     */
    public function login(Request $request)
    {
        $title = '登录';
        return view('account.login',[
            'title'=>$title
        ]);
    }
    /*
    
    /*
     * 登出
     */
    public function logout(Request $request)
    {
        Session::flush();
        return redirect(route('login'));
    }
    /*
     * 登录ajax服务
     */
    public function loginAjax(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $rememeber = $request->get('rememeber');

        $result = [];

        $user = User::forNameOrMobile($username)->first();
        if($user)
        {
            if($user->password == $this->makePassword($password))
            {
                $result['code'] = 200;
                $result['msg'] = 'success';

                Session::put('user',$user);
            }
            else
            {
                $result['code'] = 401;
                $result['msg'] = '请输入正确的用户名和密码!';
            }
        }
        else
        {
            $result['code'] = 401;
            $result['msg'] = '用户不存在！';
        }

        return response()->json($result);
    }
    /*
     * 用户列表
     */
    public function userList(Request $request)
    {
        $userList = new AdvancedListView($request);
        $userList->addCol('用户名','name');
        $userList->addCol('手机号','mobile');
        $userList->addCol('是否有效','valid',['type'=>'render','content'=>function($row){
            if($row->valid)
            {
                return '<button type="button" class="btn btn-success btn-xs">Y</button>';
            }
            else
            {
                return '<button type="button" class="btn btn-danger btn-xs">N</button>';
            }
        }]);
        $userList->addCol('添加时间','created_at');
        $userList->addCol('修改时间','updated_at');
        if($this->hasPermission('userDetail'))
        {
            $userList->detail('userDetail');
        }
        if($this->hasPermission('userDelete'))
        {
            $userList->delete('userDelete');
        }
        if($this->hasPermission('userUpdate'))
        {
            $userList->update('userUpdate');
        }

        $userList->setBarTitle('用户列表');
        $userList->setTitle('用户列表');
        $userList->setDataSource(User::all());
        $userList->setLeftMenu($this->getLeftMenu());
        $userList->setTopMenu($this->getTopMenu());
        $userList->updateContext();

        return $userList->render();
    }
    public function userDetail(Request $request)
    {
        $id = $request->get('id');
        $user = User::findOrFail($id);

            $detail = new DetailView($request);
            $detail->addCol('用户名','name');
            $detail->addCol('手机','mobile');
            $detail->addCol('是否有效','valid','yes_no');
            $detail->addCol('权限组','role','list','name');
            $detail->addCol('添加时间','created_at');
            $detail->addCol('更新时间','updated_at');

            $detail->setBarTitle($user->name.' 的详细信息');
            $detail->setDataSource($user);
            $detail->setLeftMenu($this->getLeftMenu());
            $detail->setTopMenu($this->getTopMenu());

            $detail->updateContext();
            return $detail->render();
    }
    /*
     * 添加用户
     */
    public function userAdd(Request $request)
    {
        $form_view = new FormView($request,UserForm::class);

        $form_view->setBarTitle('新增用户');
        $form_view->setTopMenu($this->getTopMenu());
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTitle('新增用户');
        $form_view->updateContext();

        if($request->ajax())
        {
            $form = $form_view->getForm();

            $form->validate(['name' => 'required|unique:user',
                'password'=>'required|min:6|max:8',
                'mobile'=>'required|numeric|unique:user']);
            if (!$form->isValid()) {
                return $form->getErrors();
            }
            else {
                $user = User::create(['name' => $request->get('name'),
                    'mobile' => $request->get('mobile'),
                    'password' => $this->makePassword($request->get('password'))]);
                if ($user) {
                    $user->roles()->attach($request->get('roles'));
                } else {
                    return json_encode(['code' => 900, 'msg' => 'Save Failed!']);
                }
                return json_encode(['code' => 100, 'msg' => 'success', 'to' => route('userList')]);
            }
        }

        return $form_view->render();
    }

    /*
     * 修改用户
     */
    public function userUpdate(Request $request)
    {
        $user = User::findOrFail($request->get('id'));

        $form_view = new FormView($request,UserForm::class,[
            'method' => 'POST',
            'url' => $request->getRequestUri(),
            'class' => 'form-horizontal'
        ]);

        $form_view->setBarTitle('更新 '.$user->name);
        $form_view->setTopMenu($this->getTopMenu());
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTitle('更新 '.$user->name);


        if ($request->ajax()) {
            $form = $form_view->getForm();

            if (!$form->isValid()) {
                return $form->getErrors();
            }
            else
            {
                $user->password = $this->makePassword($request->get('password'));
                $user->roles()->sync($request->get('roles'));
                $user->save();
            }
            return json_encode(['code'=>100,'msg'=>'success','to'=>route('userList')]);

        }
        else
        {
            $form_view->getForm()->addData($user->toArray());
            $form_view->getForm()->rebuildForm();
        }
        $form_view->updateContext();

        return $form_view->render();
    }

    /*
     * 删除用户
     */
    public function userDelete(Request $request)
    {
        $id = $request->get('id');
        $user = User::findOrFail($id);
        if($request->method() == 'POST')
        {
            $user->roles()->detach();
            $user->delete();
            return redirect()->route('userList');
        }
        $delete = new DeleteView($request);
        $delete->setTitle('删除 '.$user->name);
        $delete->setBarTitle('删除 '.$user->name);
        $delete->setLeftMenu($this->getLeftMenu());
        $delete->setTopMenu($this->getTopMenu());
        $delete->setDoneRoute('userList');
        $delete->updateContext();
        return $delete->render();
    }

    /*
     * 更新组
     */
    public function roleUpdate(Request $request)
    {
        $id = $request->get('id');
        $role = Role::findOrFail($id);


        $form_view = new FormView($request,RoleForm::class,[
            'method' => 'POST',
            'url' => $request->getRequestUri(),
            'class' => 'form-horizontal']
        );
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTopMenu($this->getTopMenu());
        $form_view->setTitle('更新 '.$role->name);
        $form_view->setBarTitle('更新 '.$role->name);

        if($request->method() == 'POST')
        {
            $form = $form_view->getForm();
            $form->validate([
                'name'=>'required|max:30',
                'permissions'=>'required'
            ]);
            if(!$form->isValid())
            {
                return $form->getErrors();
            }
            else{
                $role->name = $request->get('name');
                $role->display_name = $request->get('display_name');
                $role->description = $request->get('description');
                $role->save();

                $role->permissions()->sync($request->get('permissions'));

                return json_encode(['code'=>100,'msg'=>'success','to'=>route('roleList')]);
            }
        }
        else
        {
            $form_view->getForm()->addData($role->toArray());
            $form_view->getForm()->rebuildForm();
        }
        $form_view->updateContext();
        return $form_view->render();
    }
    /*
     * 添加组
     */
    public function roleAdd(Request $request)
    {
        $form_view = new FormView($request,RoleForm::class,[
            'method' => 'POST',
            'url' => route('roleAdd'),
            'class' => 'form-horizontal']);

        $form_view->setTitle('添加组');
        $form_view->setBarTitle('添加组');
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTopMenu($this->getTopMenu());

        $form_view->updateContext();

        if($request->ajax()){
            $form = $form_view->getForm();
            $form->validate([
                'name' => 'required|max:20|unique:role',
                'permission' => 'required'
            ]);
            if (!$form->isValid()) {
                return $form->getErrors();
            } else {
                $role = Role::create(['name' => $request->get('name'),
                    'display_name' => $request->get('display_name'),
                    'description' => $request->get('description')]);
                if ($role) {
                    $role->permission()->sync($request->get('permissions'));
                }
                return json_encode(['code'=>100,'msg'=>'success','to'=>route('roleList')]);
            }
        }
        return $form_view->render();
    }
    /*
     * 删除组
     */
    public function roleDelete(Request $request)
    {
        $id = $request->get('id');
        $role = Role::findOrFail($id);
        if($request->method() == 'POST')
        {
            $role->permissions()->detach();
            $role->delete();
            return redirect()->route('roleList');
        }
        $delete = new DeleteView($request);
        $delete->setTitle('删除 '.$role->name);
        $delete->setBarTitle('删除 '.$role->name);
        $delete->setLeftMenu($this->getLeftMenu());
        $delete->setTopMenu($this->getTopMenu());
        $delete->setDoneRoute('roleList');
        $delete->updateContext();
        return $delete->render();
    }
    /*
     * 组列表
     */
    public function roleList(Request $request)
    {
        $roleList = new AdvancedListView($request);
        $roleList->setTitle('组列表');
        $roleList->setBarTitle('组列表');
        $roleList->addCol('角色名','name');
        $roleList->addCol('说明','description');
        $roleList->addCol('添加时间','created_at');
        $roleList->addCol('修改时间','updated_at');
        $roleList->setDataSource(Role::all());
        $roleList->setLeftMenu($this->getLeftMenu());
        $roleList->setTopMenu($this->getTopMenu());
        if($this->hasPermission('roleDetail'))
        {
            $roleList->detail('roleDetail');
        }
        if($this->hasPermission('roleDelete'))
        {
            $roleList->delete('roleDelete');
        }
        if($this->hasPermission('roleUpdate'))
        {
            $roleList->update('roleUpdate');
        }

        $roleList->updateContext();

        return $roleList->render();
    }
    /*
     * 组详情
     */
    public function roleDetail(Request $request)
    {
        $id = $request->get('id');
        $role = Role::findOrFail($id);
        $detail = new DetailView($request);

        $detail->addCol('组名称','name');
        $detail->addCol('简介','description');
        $detail->addCol('添加时间','created_at');
        $detail->addCol('更新时间','updated_at');
        $detail->setLeftMenu($this->getLeftMenu());
        $detail->setTopMenu($this->getTopMenu());
        $detail->setTitle($role->name.' 的详情');
        $detail->setBarTitle($role->name.' 的详情');
        $detail->setDataSource($role);
        $detail->updateContext();

        return $detail->render();
    }
    /*
     *权限列表
     */
    public function permissionList(Request $request)
    {
        $perm_list = new AdvancedListView($request);
        $perm_list->addCol('菜单','menu');
        $perm_list->addCol('名称','name');
        $perm_list->addCol('是否显示','show',['type'=>'render','content'=>function($row){
            if($row->show)
            {
                return '<button type="button" class="btn btn-success btn-xs">Y</button>';
            }
            else
            {
                return '<button type="button" class="btn btn-danger btn-xs">N</button>';
            }
        }]);
        $perm_list->addCol('添加时间','created_at');
        $perm_list->addCol('修改时间','updated_at');
        $perm_list->setBarTitle('用户列表');
        $perm_list->setTitle('用户列表');
        $perm_list->setLeftMenu($this->getLeftMenu());
        $perm_list->setTopMenu($this->getTopMenu());

        $perm_list->setDataSource(DB::table('permission')->leftJoin('menu','menu.id','=','permission.menu_id')
            ->select(['menu.name as menu','permission.name','permission.show','permission.created_at','permission.updated_at'])
        );

        if($this->hasPermission('permissionDelete'))
        {
            $perm_list->delete('permissionDelete');
        }

        $perm_list->updateContext();

        return $perm_list->render();
    }
    public function permissionDetail(Request $request)
    {
        $id = $request->get('id');
        $perm = Permission::findOrFaid($id);
        $detail = new DetailView($request);

        $detail->addCol('名称','name');
        $detail->addCol('所属菜单','menu','text','name');
        $detail->addCol('添加时间','created_at');
        $detail->addCol('更新时间','updated_at');
        $detail->setLeftMenu($this->getLeftMenu());
        $detail->setTopMenu($this->getTopMenu());
        $detail->setTitle($perm->name.' 的详情');
        $detail->setBarTitle($perm->name.' 的详情');
        $detail->setDataSource($perm);
        $detail->updateContext();

        return $detail->render();
    }
    public function permissionAdd(Request $request)
    {
        $form_view = new FormView($request,PermissionForm::class);

        $form_view->setTitle('添加权限');
        $form_view->setBarTitle('添加权限');
        $form_view->setLeftMenu($this->getLeftMenu());
        $form_view->setTopMenu($this->getTopMenu());

        if($request->ajax()) {
            $form = $form_view->getForm();
            $form->validate(['name' => 'required|max:20|unique:permission',
                'route_name' => 'required|unique:permission',
                'menu_id' => 'required'
            ]);
            if (!$form->isValid())
            {
                return $form->getErrors();
            }
            else
            {
                $perm = new Permission();
                if ($perm) {
                    $perm->name = $request->get('name');
                    $perm->menu_id = $request->get('menu_id');
                    $perm->description = $request->get('description');
                    $perm->show = $request->get('show')=='on'?1:0;
                    $perm->route_name = $request->get('route_name');
                    $perm->save();

                }
                else
                {
                    return json_encode(['code'=>900,'msg'=>'Save Failed!']);
                }
                return json_encode(['code'=>100,'msg'=>'success','to'=>route('permissionList')]);
            }
        }
        $form_view->updateContext();
        return $form_view->render();
    }
    //用户信息
    public function profile(Request $request)
    {
        $view = new BaseView($request);
        $view->setTemplate('account.profile');
        $view->setTitle('用户信息');
        $view->setTopMenu($this->getTopMenu());
        $view->setLeftMenu($this->getLeftMenu());
        $view->setBarTitle('用户信息');

        $view->updateContext();
        return $view->render();
    }

}
