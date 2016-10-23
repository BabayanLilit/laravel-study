<?php
$title = 'Добавление отдела';
?>
@extends('layouts.app')
@section('title')
{{  $title }}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $title }}</div>
                    <div class="department-form-container">
                        @include('common.errors')
                        <form action="{{ url('department/') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="submit" value="Y">
                            <div class="form-group"><input class="form-control" type="text" placeholder="Название отдела"
                                                           name="name"
                                                           required
                                                           value="{{ old('name') }}"></div>
                            <button type="submit" id="add-department" class="btn btn-save">
                                Сохранить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
