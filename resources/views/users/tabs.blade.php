<h1>{{ $user->channel }}</h1>
<h1 class="text-right">{{ $user->name }}</h1>

@include('follow.follow_button', ['user' => $user])

<ul class="nav nav-tabs nav-pills nav-fill nav-justified mt-4 mb-2" >
    <li class="nav-item">
        <a href="{{ route('users.show',['id' => $user->id]) }}" 
            class="nav-link {{ Request::is('users/' . $user->id) ? 'active pale' : '' }}">
            動画<br>
            <div class="badge badge-secondary">
                {{ $count_movies }}
            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('followers',['id' => $user->id]) }}" 
            class="nav-link {{ Request::is('users/*/followers') ? 'active pale' : '' }}">
            フォロワー<br>
            <div class="badge badge-secondary">
                {{ $count_followers }}
            </div>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('followings',['id' => $user->id]) }}" 
            class="nav-link {{ Request::is('users/*/followings') ? 'active pale' : '' }}">
            フォロー中<br>
            <div class="badge badge-secondary">
                {{ $count_followings }}
            </div>
        </a>
    </li>
</ul>