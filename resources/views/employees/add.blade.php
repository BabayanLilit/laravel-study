<?php
$title = 'Добавление сотрудника';
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
                    <div class="employee-form-container">
                        @if(!count($departments))
                            Необходимо сначала создать отделы
                            @else
                        @include('common.errors')
                        <form action="{{ url('employee/') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="submit" value="Y">
                            <div class="form-group"><input class="form-control" type="text" placeholder="Имя"
                                                           name="name"
                                                           required
                                                           value="{{ old('name') }}"></div>
                            <div class="form-group"><input class="form-control" type="text" placeholder="Фамилия"
                                                           name="lastname"
                                                           value="{{ old('lastname') }}"></div>
                            <div class="form-group"><input class="form-control" type="text" placeholder="Отчество"
                                                           name="patronymic"
                                                           value="{{ old('patronymic') }}">
                            </div>

                            <fieldset class="form-group">
                                <div>Пол</div>
                                <div class="radio-inline">
                                    <lablel><input type="radio"
                                                   @if(old('gender', 'm') == 'm') checked
                                                   @endif name="gender"
                                                   id="gender-man" value="m"> Мужской
                                    </lablel>

                                </div>
                                <div class="radio-inline">
                                    <lablel><input type="radio"
                                                   @if(old('gender', 'w') == 'w') checked
                                                   @endif name="gender"
                                                   id="gender-woman" value="w"> Женский
                                    </lablel>

                                </div>
                            </fieldset>

                            <div class="form-group"><input class="form-control" type="text"
                                                           placeholder="Заработная плата"
                                                           name="pay"
                                                           value="{{ old('pay') }}"></div>
                            <fieldset class="form-group">
                                <div>Отделы</div>
                                @foreach ($departments as $department)
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    @if(in_array($department->id, (array) old('departments'))) checked @endif
                                            type="checkbox" name="departments[]" value="{{$department->id}}">
                                            {{$department->name}}</label>

                                    </div>
                                @endforeach
                            </fieldset>
                            <button type="submit" id="add-employee" class="btn btn-save">
                                Сохранить
                            </button>
                        </form>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
