<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['user_id', 'url', 'comment'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * 動画URLからvパラメータを取得する
     * Movieクラスに関するメソッドではないので、将来Toolクラスに移行することを検討してください
     * 
     * @url 動画URL全体
     * @return vパラメータ
     * @see MoviesController, RestappController
     */
    public static function urlToVideoParam($url){
                // 入力URLからクエリパラメータのvを切り出す
        $url    = strstr($url, 'v=', false);
        $start  = strpos($url, '=') + 1;
        $end    = strpos($url, '&');
        $url    = substr($url, $start, $end ? $end - $start : 11);
        
        return $url;
    }
}
