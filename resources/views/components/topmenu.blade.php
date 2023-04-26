<div class="navbar-fixed-top navbar-first">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="navbar-brand">
                    <a href="https://asu.edu.ru">
                        <img class="main-img" height="137%" src="/images/asu_logo.png">
                    </a>
                    <a href="{{ url(App\Http\Middleware\LocaleMiddleware::getLocale().'/') }}">
                        <img class="main-img" height="130%" src="/images/logo-red-ru.svg">
                        <div class="main-title">
                            <span class="main-title-speech">Speech</span><br>
                            <span class="main-title-train">TRAIN</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 btn-locale">
                <a href="{{ route('setlocale', ['lang' => 'en']) }}" class="{{ App\Http\Middleware\LocaleMiddleware::getLocale() === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('setlocale', ['lang' => 'ru']) }}" class="{{ App\Http\Middleware\LocaleMiddleware::getLocale() === null ? 'active' : '' }}">RU</a>
            </div>
        </div>
    </div>
</div>