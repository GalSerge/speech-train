<!doctype html>
<html lang="{{ App::currentLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/images/logo-red-ru.svg" type="image/svg+xml">
    <link rel="stylesheet" href={{ asset("css/bootstrap.css") }}>
    <link rel="stylesheet" href={{ asset("css/main.css") }}>
    <meta name="description" content="{{ __('repository.title') }}" />
    <title>{{ __('repository.title') }}</title>
</head>
<body>
@include('components.topmenu')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-sm-12 col-xs-12">
            <div class="about">{!! __('repository.about') !!}</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-sm-12 col-xs-12 search-selectors">
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    {{ __('repository.lang_title') }}:
                    <select class="form-control" id="search-lang">
                        <option value="0" selected>{{ __('repository.other_title') }}</option>
                        <option value="1">Русский</option>
                        <option value="2">English</option>
                    </select>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    {{ __('repository.type_translate_title') }}:
                    <select class="form-control" id="search-type-translate">
                        <option value="0" selected>{{ __('repository.other_title') }}</option>
                        <option value="1">{{ __('repository.no_notes_title') }}</option>
                        <option value="2">{{ __('repository.with_notes_title') }}</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    {{ __('repository.speech_number_title') }}:
                    <input type="text" value="" class="form-control" id="search-number">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ __('repository.keywords_title') }}:
                    <select class="form-control" id="search-keywords-list" multiple multiselect-hide-x="true" multiselect-search="true" multiselect-select-all="true">
                        @foreach($keywords as $keyword)
                            <option value="{{ $keyword['keyword_id'] }}">{{ $keyword['word'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12">
            <button type="button" onclick="searchRecords()" class="search-button">{{ __('repository.search_title') }}</button>
        </div>
    </div>
    <div id="records-list">
        @include('components.recordslist')
    </div>
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
<script src={{ asset("js/bootstrap.min.js") }}></script>
<script src={{ asset("js/multiselect-dropdown-main/multiselect-dropdown.js") }}></script>
<script src={{ asset("js/app.js") }}></script>
<style>
    .multiselect-dropdown {
        width: 100%;
    }
</style>
</body>
</html>