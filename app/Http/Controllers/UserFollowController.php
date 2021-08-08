<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 中間テーブルに関わるコントローラー
 */
class UserFollowController extends Controller
{
    /**
     * フォローする
     */ 
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back();
    }
    
    /**
     * フォローを外す
     */
    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
