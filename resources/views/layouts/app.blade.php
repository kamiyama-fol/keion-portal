<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title', 'ポータルサイト')</title>
</head>

<body>
    <header>
        <h1>京都産業大学 軽音楽部ポータルサイト</h1>
        <ul class="menu">
            <li><a href="">スタジオ予約</a></li>
            <li>バンド登録</li>
            <li>設定</li>
            <li>幹部用</li>
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">ログアウト</button>
            </form>
            @endauth
        </ul>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2024 京都産業大学 電子計算機応用部</p>
    </footer>
</body>

</html>