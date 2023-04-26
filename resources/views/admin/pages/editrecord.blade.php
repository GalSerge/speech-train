@extends('admin.page')

@section('content')
    <h1>{{ $title }}</h1>
    <form action="{{ url(Request::url()) }}" method="post" class="editform" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            Заголовок:
            <input type="text" name="record[title]" value="{{ $record['title'] ?? '' }}" class="form-control">
        </div>
        <div class="form-group">
            Описание:
            <textarea name="record[description]" id="content">{{ $record['description'] ?? '' }}</textarea>
        </div>
        <div class="form-group">
            Ссылка на видео:
            <textarea name="record[video]" class="form-control">{{ $record['video'] ?? '' }}</textarea>
        </div>
        <div class="form-group">
            Номер речи:
            <input type="text" name="record[number_speech]" value="{{ $record['number_speech'] ?? '' }}" class="form-control">
        </div>
        <div class="form-group">
            Продолжительность (в секундах):
            <input type="number" name="record[long_time]" value="{{ $record['long_time'] ?? '' }}" class="form-control">
        </div>
        <div class="form-group">
            Язык:
            <select class="form-control" name="record[typelang_id]">
                @foreach($typelangs as $lang)
                    @if(isset($record['typelang_id']) && $record['typelang_id'] == $lang['typelang_id'])
                        <option value="{{ $lang['typelang_id'] }}" selected>{{ $lang['title'] }}</option>
                    @else
                        <option value="{{ $lang['typelang_id'] }}">{{ $lang['title'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            Вид перевода:
            <select class="form-control" name="record[type_translate]">
                @if(isset($record['type_translate']) && $record['type_translate'] == 1)
                    <option value="1" selected>последовательный перевод без записи</option>
                    <option value="2">последовательный перевод с записью</option>
                @else
                    <option value="1">последовательный перевод без записи</option>
                    <option value="2" selected>последовательный перевод с записью</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            Ключевые слова (для выбора нескольких зажмите Ctrl):
            <select id="tags-list" name="record[keywords][]" class="form-control" size="10" multiple>
                @foreach($keywords as $keyword)
                    @if(isset($record['keywords_ids']) && in_array($keyword['keyword_id'], $record['keywords_ids']))
                        <option value="{{ $keyword['keyword_id'] }}" selected>{{{ $keyword['word'] }}}</option>
                    @else
                        <option value="{{ $keyword['keyword_id'] }}">{{{ $keyword['word'] }}}</option>
                    @endif
               @endforeach
            </select>
        </div>
        <div class="form-group add-tag-group">
            Добавить новое ключевое слово:
            <div class="form-group">
                <input type="text" id="add-tag-text" value="" class="form-control">
            </div>
            <button type="button" onclick="addKeyword()" class="btn btn-primary">Добавить</button>
        </div>
        <div class="form-group">
            @if(isset($record['active']) && $record['active'])
                <input class="form-check-input" type="checkbox" name="record[active]" value="1" id="flexCheckDefault" checked>
            @else
                <input class="form-check-input" type="checkbox" name="record[active]" value="1" id="flexCheckDefault">
            @endif
            Запись доступна
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <div class="form-group">
            <strong>Последнее редактирование: </strong>{{ $record['updated_at'] ?? date('Y-m-d H:i:s') }}<br>
        </div>
    </form>
    <script>
        CKEDITOR.replace( 'content', {
            filebrowserBrowseUrl: '{{ asset(route('ckfinder_browser')) }}',
            filebrowserImageBrowseUrl: '{{ asset(route('ckfinder_browser')) }}?type=Images',
            filebrowserUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '{{ asset(route('ckfinder_connector')) }}?command=QuickUpload&type=Images',
        });
    </script>
    @include('ckfinder::setup')
@endsection

