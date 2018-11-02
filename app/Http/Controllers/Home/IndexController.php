<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    # 前台首页
    public function index()
    {
        return view('home.index.index');
    }
    #登陆页面
    public function login()
    {
        return view('home.index.index');
    }
}
