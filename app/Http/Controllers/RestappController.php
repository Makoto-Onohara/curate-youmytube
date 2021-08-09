<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Movie;

class RestappController extends Controller
{
    /**
     * ユーザーの一覧.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        return response()->json(
            [
                'users' => $users
            ],
            200,                                        // ステータスコード（成功）
            [],                                         // レスポンスヘッダ
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT    // jsonの表示オプション（日本語文字化け対策|整形)
        );
    }

    /**
     * 動画登録フォーム表示.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(1);
        $movies = $user->movies;
        
        $data = [
            'movies' => $movies
        ];
        
        return view('rest.create', $data);
    }

    /**
     * 動画登録処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'url'       => 'required|max:11',
            'url'       => 'required',
            'comment'   => 'max:36',
        ]);
        
        User::find(1)->movies()->create([
            // 'url'       => $request->url,
            // 'url'       => $url,
            'url'       => Movie::urlToVideoParam($request->url),
            'comment'   => $request->comment,
        ]);
        
        $movies = User::find(1)->movies;
        
        return response()->json(
            [
                'movies' => $movies
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT 
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $movies = $user->movies;
        return response()->json(
            [
                'user' => $user
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);  // 動画IDから動画を取得
        $user = $movie->user;       // 指定の動画を所有しているユーザーを取得
        
        // ユーザーID=1の場合のみRESTfulからの動画削除を許可
        if($user->id == 1){
            $movie->delete();
        }
        
        $movies = $user->movies;
        
        return response()->json(
            [
                'movies' => $movies
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
        
    }
}
