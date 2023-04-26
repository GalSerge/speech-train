@extends('admin.page')

@section('content')
    <h1>{{ $title }}</h1>
    <a href="{{ url('/admin/add-record') }}">
        <img src="{{ url('/public/images/icons/add.svg') }}">
        Добавить запись
    </a>
    <hr>
    <ul class="parent">
        @foreach($records as $record)
            <li class="edit-item">
                <a href="{{ url('/admin/edit-record/'.$record['record_id']) }}"><img src="{{ url('/public/images/icons/edit.svg') }}" title="Редактировать"></a>&nbsp;&nbsp;
                @if($record['active'])
                    <span>{{ $record['title'] }}</span>
                @else
                    <span style="color: #9b9b9b;">{{ $record['title'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>
@endsection