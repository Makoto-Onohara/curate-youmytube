@extends('layouts.app')

@section('content')

    <div class="text-right">
        {{ Auth::user()->name }}
    </div>
    
    <h2 class="mt-5">動画を登録する</h2>
    
    {!! Form::open(['route'=>'movies.store']) !!}
        <div class="form-group mt-5">
            {!! Form::label('url','新規登録YouTube動画 "ID" を入力する',['class'=>'text-success']) !!}
                <br>
                例) 登録したいYouTube動画のURLが
                    <span>
                        https://www.youtube.com/watch?v=-bNMq1Nxn5o なら
                    </span>                
                <div>
                    "v="の直後にある"<span class="text-success">-bNMq1Nxn5o</span>"を入力
                 </div>
                 
            {!! Form::text('url',null,
                    [
                        'class'=>'form-control',
                        'placeholder' => '例）-bNMq1Nxn5o',
                    ]
                )
            !!}
             
            {!! Form::label('comment','登録動画へのコメント',['class'=>'mt-3']) !!}
            {!! Form::textarea(
                    'comment',null,
                    [
                        'class'=>'form-control',
                        'rows' => 3,
                        'placeholder' => 'コメントがあれば入力してね（36文字以内）！'
                    ]
                )
            !!}
             
            {!! Form::submit('動画を登録する',['class'=>'button btn btn-primary mt-5 mb-5']) !!}
        </div>
        
        {!! Form::close() !!}
        
        <h2 class="mt-5">お主の登録済み動画の一覧じゃ！</h2>
        
        @include('movies.movies',['movies' => $movies])
        
    @endsection