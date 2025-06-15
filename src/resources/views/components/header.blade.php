<header class="header">
    <div class="header__logo">
        <a href="/"><img src="{{ asset('img/logo.png') }}" alt="ロゴ"></a>
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
    @else(Auth::check())
    <nav class="header__nav">
        <ul>
            <li><a href="admin/attendance_list">勤怠一覧</a></li>
            <li><a href="admin/staff_list">スタッフ一覧</a></li>
            <li><a href="admin/request_list">申請一覧</a></li>
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