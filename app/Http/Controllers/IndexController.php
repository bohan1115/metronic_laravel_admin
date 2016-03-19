<?php
/**
 * Created by PhpStorm.
 * User: lixiaojun
 * Date: 15/11/18
 * Time: 08:13
 * Description:首页
 */

namespace App\Http\Controllers;
use App\Http\Models\Goods\Category;
use App\Http\Models\Goods\Goods;
use App\Http\Models\Member\Member;
use App\Http\Models\Order\Order;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class IndexController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Dashboard';
        $title_description = '统计 &amp; 分析';



        return view('index',[
            'left_menu'=>$this->getLeftMenu(),
            'prefix'=>'/',
            'route'=>'index',
            'title'=>$title,
            'title_description'=>$title_description,
            'bar_title'=>$title
        ]);

    }
}