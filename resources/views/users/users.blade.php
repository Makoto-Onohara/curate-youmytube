<h2 class="mt-5 mb-5">users</h2>
    
<div class="movies row mt-5 text-center">
    
    @foreach ($users as $key => $user)
    
        @php
        
            $movie = $user->movies->last();
            
            if($movie){
                $key_name = config('app.key_name');
                $get_api_url = "https://www.googleapis.com/youtube/v3/videos?id=$movie->url&key=$key_name&part=snippet";
                $json = file_get_contents($get_api_url);
                
                if($json){
                    $getData = json_decode($json, true);
                    if($getData['pageInfo']['totalResults'] == 0){
                        $video_title = "※動画が未登録です";
                    }else{
                        $video_title = $getData['items']['0']['snippet']['title'];
                    }
                }else{
                    $video_title="※一時的な情報制限中です";
                }
            }
        
        @endphp
        
        {{-- // １列に３つ表示 --}}
        @if ($loop->iteration % 3 == 1 && $loop->iteration != 1)
        
            </div>
        
            <div class="row text-center mt-3">
                
        @endif
            <div class="col-lg-4 mb-5">
                
                <div class="movie text-left d-inline-block">
                    
                    {!! link_to_route('users.show',$user->name,['id'=>$user->id]) !!}
                    
                    {{-- // 埋め込み動画 --}}
                    <div>
                        @if ($movie)
                            <iframe width="290" height="163.125" 
                                src="{{ 'https://www.youtube.com/embed/'.$movie->url }}?controls=1&loop=1&playlist={{ $movie->url }}"
                                frameborder="0">
                            </iframe>
                        @else
                            <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
                            @php
                                $video_title="※動画が未登録です";
                            @endphp
                        @endif
                        
                    </div>
                    
                    {{-- // 動画のコメント --}}
                    <p>
                        @if (isset($movie->comment))
                            {{ $movie->comment }}
                        @else
                        {{-- コメントは36文字制限でコントローラーでバリデーションをかけられているが、 --}}
                        {{-- ビューではバリデーションがかからず表示されるので加工する --}}
                            @php
                                $video_title = mb_substr($video_title, 0, 36, "UTF-8");
                            @endphp
                        
                            {{ $video_title }}
                        @endif
                    </p>
                    
                    {{-- // フォローボタン--}}
                    @include('follow.follow_button', ['user'=>$user])
                    
                </div>
            </div>

    @endforeach
</div>

{{ $users->links('pagination::bootstrap-4') }}