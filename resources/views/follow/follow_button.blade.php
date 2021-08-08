{{-- {{-- ユーザーがログイン中かチェック --}}
@if(Auth::check())
    
    {{-- {{-- ログイン中のユーザーと表示のユーザーが一致しない場合、「フォローを外す」ボタン --}}
    @if(Auth::id() != $user->id)
    
        @if(Auth::user()->is_following($user->id))
            {{-- 「フォローを外す」ボタンを表示する --}}
            {{-- フォローを外す処理のコントローラーにリダイレクトするようにする --}}
            {!! Form::open(['route' => ['unfollow', $user->id], 'method' => 'delete']) !!}
                {!! Form::button('<i class="fas fa-minus mr-2"></i>フォローを外す',
                    [
                        'class' => "button btn btn-danger mt-1",
                        'type' => 'submit'
                    ])
                !!}
            {!! Form::close() !!}
        @else
            {{-- 「フォローする」ボタンを表示する --}}
            {!! Form::open(['route' => ['follow', $user->id]]) !!}
                {!! Form::button('<i class="fas fa-plus mr-2"></i>フォローする',
                    [
                        'class' => "button btn btn-primary mt-1",
                        'type' => 'submit'
                    ])
                !!}
            {!! Form::close() !!}
        
        @endif
        
    @endif
    
@endif