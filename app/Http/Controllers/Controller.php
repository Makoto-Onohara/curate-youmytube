<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * 各種カウント
     * 
     * @param user ユーザー
     * @return 登録動画、フォロー、フォロワーの数の配列
     */ 
    public function counts($user) {
        $count_movies       = $user->movies()->count();     // 登録動画数
        $count_followings   = $user->followings()->count(); // フォロー数
        $count_followers    = $user->followers()->count();  // フォロワー数
        
        
        return [
            'count_movies'      => $count_movies,       // 動画の数
            'count_followings'  => $count_followings,   // フォロー数
            'count_followers'   => $count_followers,    // フォロワー数
        ];
    }
}
