@php
    $langs = [1 => 'Русский', 2 => 'English'];
    $translates = [1 => 'no_notes_title', 2 => 'with_notes_title'];
@endphp
<h2>{{ __('repository.'.$title) }}</h2>
@foreach($records as $record)
    <div class="row record-card">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <img class="record-img" src="https://img.youtube.com/vi/{{ $record['video_code'] }}/hqdefault.jpg">
        </div>
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 record-title">
                    <h3><a target="_blank" href="{{ url(App\Http\Middleware\LocaleMiddleware::getLocale().'/records/'.$record['record_id']) }}">{{ $record['title'] }}</a>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="record-meta-title">
                        <img src="{{ url('/public/images/icons/lang2.svg') }}">
                    </div>
                    <div>
                        {{ $record['type_lang_title'] }}
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="record-meta-title">
                        <img src="{{ url('/public/images/icons/pencil-text.svg') }}">
                    </div>
                    <div>
                        {{ __('repository.'.$translates[$record['type_translate']]) }}
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="record-meta-title">
                        <img src="{{ url('/public/images/icons/timer.svg') }}">
                    </div>
                    <div>
                        @if ($record['long_time'] >= 3600)
                            {{ sprintf('%02d:%02d:%02d', ($record['long_time'] / 3600), ($record['long_time'] / 60 % 60), $record['long_time'] % 60) }}
                        @else
                            {{ sprintf('%02d:%02d', ($record['long_time'] / 60 % 60), $record['long_time'] % 60) }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 keywords-block">
                    <b>{{ __('repository.keywords_title') }}</b>
                    <ul class="record-keywords-list">
                        @foreach($record['keywords'] as $word)
                            <li>
                                {{ $word['word'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach