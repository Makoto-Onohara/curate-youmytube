<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class MoviesController extends Controller
{
    //
    public function create()
    {
        $user   = \Auth::user();
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        
        // ビューに渡すオブジェクトを配列に格納
        $data = [
            'user'      => $user,
            'movies'    => $movies,
        ];
        
        return view('movies.create', $data);
    }
    
    // 動画の登録
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'url'       => 'required|max:11',
            'url'       => 'required',
            'comment'   => 'max:36',
        ]);
        
        $request->user()->movies()->create([
            // 'url'       => $request->url,
            'url'       => Movie::urlToVideoParam($request->url),
            'comment'   => $request->comment,
        ]);
        
        return back();
    }
    
    // 動画の削除
    public function destroy($id)
    {
        $movie = Movie::find($id);
        
        if (\Auth::id() == $movie->user_id) {
            $movie->delete();
        }
        
        return back();
    }
}
