<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    /**
     * ユーザー一覧表示
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(9);
        
        // 上で取得した$usersをビューでしたい
        // ビューにusersという変数名で$usersオブジェクトを渡す
        return view('welcome', [
            'users' => $users,
        ]);
    }
    
    
    /**
     * ユーザー情報を表示
     * 
     * @param $id ユーザーID
     */
    public function show($id)
    {
        $user   = User::find($id);
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        
        $data = [
            'user'      => $user,
            'movies'    => $movies,
        ];
        
        $data += $this->counts($user);
        return view('users.show', $data);
    }
   
    
    /**
     * ユーザー名、チャンネル名の変更
     * 
     * @param $request リクエスト
     */
    public function rename(Request $request)
    {
        $this->validate($request, [
            'channel'   => 'required|max:15',
            'name'      => 'required|max:15',
        ]);
        
        $user   = \Auth::user();
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        
        // フォームの入力内容を取得
        $user->channel  = $request->channel;
        $user->name     = $request->name;
        // 差分保存
        $user->save();
        
        // ビューに渡す情報を配列にまとめる
        $data = [
            'user' => $user,
            'movies' => $movies,
        ];
        $data += $this->counts($user);
        
        // ビューにusers.showとしてdataを渡す
        return view('users.show', $data);
        
    }
    
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(9);
        
        // ビューに渡すオブジェクト
        $data = [
            'user' => $user,            //
            'users' => $followings,     //
        ];
        
        $data += $this->counts($user);
        
        return view('users.followings', $data);
        
    }
    
    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(9);
        
        // ビューに渡すオブジェクト
        $data = [
            'user' => $user,        //
            'users' => $followers,  //
        ];
        
        $data += $this->counts($user);
        
        return view('users.followers', $data);
    }
}
