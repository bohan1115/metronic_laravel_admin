<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Account\User;
use App\Http\Models\Account\Role;
use App\Http\Models\Account\Permission;
use App\Http\Models\Account\Menu;
use App\Http\Models\Example;

class AccountTableSeeder extends Seeder {

    use \App\Http\Utils;
    public function run()
    {
        DB::table('user')->delete();
        $user = User::create(['name'=>'admin',
                    'mobile'=>'13688888888',
                    'password'=>$this->makePassword('123456')
                    ]);

        DB::table('menu')->delete();
        $menu = Menu::create([
                'prefix'=>'account',
                'name'=>'用户中心',
                'icon'=>'icon-user']);

        $menu1 = Menu::create([
            'prefix'=>'example',
            'name'=>'EXAMPLE',
            'icon'=>'icon-test']);

        DB::table('role')->delete();
        $role = Role::create([
            'name'=>'管理员',
            'display_name'=>'管理员',
            'description'=>'管理员']);


        DB::table('permission')->delete();

        Permission::create(['menu_id'=>$menu->id,'name'=>'添加用户',
            'display_name'=>'添加用户','route_name'=>'userAdd','show'=>'1']);
        Permission::create(['menu_id'=>$menu->id,'name'=>'用户',
            'display_name'=>'用户','route_name'=>'userList','show'=>'1']);
        Permission::create(['menu_id'=>$menu->id,'name'=>'更新用户信息',
            'display_name'=>'更新用户信息','route_name'=>'userUpdate','show'=>'0']);
        Permission::create(['menu_id'=>$menu->id,'name'=>'删除用户',
            'display_name'=>'删除用户','route_name'=>'userDelete','show'=>'0']);


        Permission::create(['menu_id'=>$menu->id,'name'=>'添加组',
            'display_name'=>'添加组','route_name'=>'roleAdd','show'=>'1']);
        Permission::create(['menu_id'=>$menu->id,'name'=>'组',
            'display_name'=>'组','route_name'=>'roleList','show'=>'1']);
        Permission::create(['menu_id'=>$menu->id,'name'=>'更新组信息',
            'display_name'=>'更新组信息','route_name'=>'roleUpdate','show'=>'0']);

        Permission::create(['menu_id'=>$menu->id,'name'=>'添加权限',
            'display_name'=>'添加权限','route_name'=>'permissionAdd','show'=>'1']);
        Permission::create(['menu_id'=>$menu->id,'name'=>'权限',
            'display_name'=>'权限','route_name'=>'permissionList','show'=>'1']);


        Permission::create(['menu_id'=>$menu1->id,'name'=>'添加',
            'display_name'=>'添加组','route_name'=>'exampleAdd','show'=>'1']);
        Permission::create(['menu_id'=>$menu1->id,'name'=>'列表',
            'display_name'=>'组','route_name'=>'exampleList','show'=>'1']);
        Permission::create(['menu_id'=>$menu1->id,'name'=>'更新',
            'display_name'=>'更新组信息','route_name'=>'exampleUpdate','show'=>'0']);

        $permids = [];
        foreach(Permission::all(['id']) as $item)
        {
            array_push($permids,$item->id);
        }
        $role->permissions()->sync($permids);
        $user->roles()->sync([$role->id]);




    }

}
class ExampleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('example')->delete();
        for($i=0;$i<60;++$i){
            Example::create(['name'=>'Test'.$i, 'sn'=>'1234567890'.$i, 'price'=>'1.00', 'status'=>'1', 'description'=>'test'.$i]);
        }
    }
}

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountTableSeeder::class);
        $this->call(ExampleTableSeeder::class);
    }
}
