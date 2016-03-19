<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/10/29
 * Time: 17:52
 */

namespace App\Http\Controllers;

use App\Http\Models\Account\Menu;
use App\Http\Models\Account\Permission;
use App\Http\Models\Account\Role;
use App\Http\Models\Account\RolePermission;
use App\Http\Models\Account\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Utils;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests,Utils;

    /*
     * 获取左边菜单
     */

    protected function getLeftMenu()
    {
        $permission = $this->getPerm();
        $left_menu = Session::get('left_menu', []);

        if (!$left_menu)
        {
            $menu_prefix = [];
            foreach ($permission as $item) {
                if ($item->show == 1) {
                    if (array_key_exists($item->menu_id, $left_menu)) {
                        $left_menu[$item->menu_id]['value'][] = $item;
                    } else {
                        $menu = Menu::find($item->menu_id);
                        $left_menu[$item->menu_id] = [];
                        $left_menu[$item->menu_id]['menu'] = $menu;
                        $left_menu[$item->menu_id]['value'] = [];
                        $left_menu[$item->menu_id]['value'][] = $item;

                        $menu_prefix[$menu->prefix] = $menu->name;
                    }
                }
            }
            Session::put('menu_prefix',$menu_prefix);
            Session::put('left_menu',$left_menu);
        }
        return $left_menu;
    }

    protected function getTopMenu()
    {
        return [];
    }

    /*
     * 上传文件处理
     */
    public function saveUploadFile(UploadedFile $upload_file,$prefix = 'default')
    {
        $file_name = date_format(Carbon::now(),'YmdHis').'.'.$upload_file->getClientOriginalExtension();
        $file_path = env('UPLOAD_FILE_PATH').$prefix.'/'.date_format(Carbon::now(),'Ymd');
        if(!is_dir(env('UPLOAD_FILE_PATH').$prefix))
        {
            mkdir(env('UPLOAD_FILE_PATH').$prefix);
        }
        if(!is_dir($file_path))
        {
            mkdir($file_path);
        }
        $upload_file->move($file_path,$file_name);

        return '/upload/'.$prefix.'/'.date_format(Carbon::now(),'Ymd').'/'.$file_name;
    }
   
}