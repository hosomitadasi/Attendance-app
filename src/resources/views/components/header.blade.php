<header class="header">
    <div class="header__logo">
        <img src="{{ asset('img/logo.png') }}" alt="ロゴ">
    </div>
    @auth
    @if (Auth::user()->role === 'user')
    <nav class="header__nav">
        <ul>
            <li><a href="{{ route('attendance.create') }}">勤怠</a></li>
            <li><a href="{{ route('attendance.list') }}">勤怠一覧</a></li>
            <li><a href="{{ route('attendance.request_list') }}">申請</a></li>
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="header__logout">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
    @elseif (Auth::user()->role === 'admin')
    <nav class="header__nav">
        <ul>
            <li><a href="{{ route('admin.attendance_list') }}">勤怠一覧</a></li>
            <li><a href="{{ route('admin.staff_list') }}">スタッフ一覧</a></li>
            <li><a href="{{ route('admin.request_list') }}">申請一覧</a></li>
            <li>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button class="header__logout">ログアウト</button>
                </form>
            </li>
        </ul>
    </nav>
    @endif
    @endauth
</header>