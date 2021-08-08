<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
    
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
        
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
        
    }
    // すでにフォローしているか確認
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }
    
    /**
     * フォローする
     * @param $userId フォローする相手のユーザーID
     */
    public function follow($userId)
    {
        // すでにフォロー済みか確認
        $existing = $this->is_following($userId);
        // フォローする相手がユーザー自身か確認
        $myself = $this->id == $userId;
        
        if (!$existing && !$myself){
            // attachの引数は、followingsの第3引数
            $this->followings()->attach($userId); // 中間テーブルに挿入
            return true; // デバッグ用
        }
        
        return false; // デバッグ用
    }
    
    /**
     * フォローを外す
     * @param $userId フォローを外す相手のユーザーID
     */
     public function unfollow($userId){
        // すでにフォロー済みか確認
        $existing = $this->is_following($userId);
        // フォローする相手がユーザー自身か確認
        $myself = $this->id == $userId;
        
        if ($existing && !$myself){
            // datachの引数は、followingsの第3引数
            $this->followings()->detach($userId); // 中間テーブルのレコード削除
        }
     }
    
    
}
