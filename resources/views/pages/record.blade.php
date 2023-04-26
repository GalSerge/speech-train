@php
    $langs = [1 => 'Русский', 2 => 'English'];
    $translates = [1 => 'no_notes_title', 2 => 'with_notes_title'];
@endphp
        <!doctype html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/images/logo-red-ru.svg" type="image/svg+xml">
    <link rel="stylesheet" href={{ asset("css/bootstrap.css") }}>
    <link rel="stylesheet" href={{ asset("css/main.css") }}>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src={{ asset("js/app.js?v=".time()) }}></script>
    <meta name="description" content="{{ $record['title'] }}"/>
    <title>{{ $record['title'] }}</title>
</head>
<body>
@include('components.topmenu')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1>{{ $record['title'] }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="record-video">
                <div class="video">
                    <div class="video-wrp">
                        {!! $record['video'] !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 record-card-meta">
            <b>{{ __('repository.keywords_title') }}</b>
            <ul class="record-keywords-list">
                @foreach($record['keywords'] as $word)
                    <li>
                        {{ $word['word'] }}
                    </li>
                @endforeach
            </ul>
            <ul class="record-meta-info">
                <li><span class="item_label">{{ __('repository.lang_title') }}: </span>{{ $record['type_lang_title'] }}</li>
                <li><span class="item_label">{{ __('repository.speech_number_title') }}: </span>{{ $record['number_speech'] }}</li>
                <li>
                    <span class="item_label">{{ __('repository.duration_title') }}: </span>
                    @if ($record['long_time'] >= 3600)
                        {{ sprintf('%02d:%02d:%02d', ($record['long_time'] / 3600), ($record['long_time'] / 60 % 60), $record['long_time'] % 60) }}
                    @else
                        {{ sprintf('%02d:%02d', ($record['long_time'] / 60 % 60), $record['long_time'] % 60) }}
                    @endif
                </li>
                <li><span class="item_label">{{ __('repository.type_translate_title') }}: </span>{{ __('repository.'.$translates[$record['type_translate']]) }}</li>
            </ul>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--            <div class="record-video">--}}
{{--                <div class="video">--}}
{{--                    <div class="video-wrp">--}}
{{--                        {!! $record['video'] !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <b>Ключевые слова</b>--}}
{{--            <ul class="record-keywords-list">--}}
{{--                @foreach($record['keywords'] as $word)--}}
{{--                    <li>--}}
{{--                        {{ $word['word'] }}--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--            <ul class="record-meta-info">--}}
{{--                <li><span class="item_label">Язык: </span>{{ $langs[$record['type_lang']] }}</li>--}}
{{--                <li><span class="item_label">Номер речи: </span>{{ $record['number_speech'] }}</li>--}}
{{--                <li>--}}
{{--                    <span class="item_label">Продолжительность: </span>--}}
{{--                    @if ($record['long_time'] >= 3600)--}}
{{--                        {{ sprintf('%02d:%02d:%02d', ($record['long_time'] / 3600), ($record['long_time'] / 60 % 60), $record['long_time'] % 60) }}--}}
{{--                    @else--}}
{{--                        {{ sprintf('%02d:%02d', ($record['long_time'] / 60 % 60), $record['long_time'] % 60) }}--}}
{{--                    @endif--}}
{{--                </li>--}}
{{--                <li><span class="item_label">Вид перевода: </span>{{ $translates[$record['type_translate']] }}</li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
                {!! __('repository.footer_info') !!}
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <ul class="social-icons">
                    <li><a target="_blank" href="https://vk.com/caspianschool30"><img src='/images/vk.png' /></a></li>
                    <li><a target="_blank" href="https://t.me/caspianschool30"><img src='/images/tg.png' /></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src={{ asset("/js/bootstrap.min.js") }}></script>
</body>
</html>