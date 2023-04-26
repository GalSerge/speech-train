@extends('admin.page')

@section('content')
    <h1>Языки перевода</h1>
    <a href="{{ url('/admin/add-typelang') }}">
        <img src="{{ url('/public/images/icons/add.svg') }}">
        Добавить язык перевода
    </a>
    <hr>
    <ul class="parent">
        @foreach($typelangs as $lang)
            <li class="edit-item">
                <a href="{{ url('/admin/edit-typelang/'.$lang['typelang_id']) }}"><img
                            src="{{ url('/public/images/icons/edit.svg') }}" title="Редактировать"></a>
                {{ $lang['title'] }}
            </li>
        @endforeach
    </ul>
@endsection