<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="/admin">
                <span class="big-title">SpeechTRAIN</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/records') }}">Записи</a>
        </li>
{{--        <li>--}}
{{--            <a href="{{ url('/admin/typelangs') }}">Языки перевода</a>--}}
{{--        </li>--}}
        <li>
            <a href="{{ url('/admin/sections') }}">Страницы</a>
        </li>
        <li>
            <a href="{{ url('/admin/admins') }}">Администраторы</a>
        </li>
        <li class="exit">
            <a href="{{ url('/admin/logout') }}">Выход</a>
        </li>
    </ul>
</div>

