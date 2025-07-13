<header class="header">
    <div class="header__logo">
        <img src="{{ asset('img/logo.png') }}" alt="ロゴ">
    </div>
    @if(Auth::check())
    <nav class="header__nav">
        <ul>
            <li><a href="attendance/create">勤怠</a></li>
            <li><a href="attendance/list">勤怠一覧</a></li>
            <li><a href="attendance/request_list">申請</a></li>
            <li>
                <form action="/logout" method="post">
                    @csrf
                    <button class="header__logout">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
    @endif
</header>