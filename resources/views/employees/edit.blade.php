<?php
/** @var \App\Employee $employee */
$default = $employee->attributesToArray();
$default['departments'] = $employee->departments->pluck('id')->toArray();

$submit = old('submit') == 'Y';
$oldDepartments = (array)old('departments', !$submit ? $default['departments'] : []);

$title = 'Редактирование сотрудника' . $default['lastname'] . ' ' . $default['name'];

?>
@section('title')
    {{  $title }}
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $title  }}</div>
                    <div class="employee-form-container">
                        @include('common.errors')
                        <form action="{{ url('employee/'.$default['id']) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="submit" value="Y">
                            <div class="form-group"><input class="form-control" type="text" placeholder="Имя"
                                                           name="name"
                                                           required
                                                           value="{{ old('name', $default['name']) }}"></div>
                            <div class="form-group"><input class="form-control" type="text" placeholder="Фамилия"
                                                           name="lastname"
                                                           value="{{ old('lastname', $default['lastname']) }}"></div>
                            <div class="form-group"><input class="form-control" type="text" placeholder="Отчество"
                                                           name="patronymic"
                                                           value="{{ old('patronymic', $default['patronymic']) }}">
                            </div>

                            <fieldset class="form-group">
                                <div>Пол</div>
                                <div class="radio-inline">
                                    <lablel><input type="radio"
                                                   @if(old('gender', $default['gender']) == 'm') checked
                                                   @endif name="gender"
                                                   id="gender-man" value="m"> Мужской
                                    </lablel>

                                </div>
                                <div class="radio-inline">
                                    <lablel><input type="radio"
                                                   @if(old('gender', $default['gender']) == 'w') checked
                                                   @endif name="gender"
                                                   id="gender-woman" value="w"> Женский
                                    </lablel>

                                </div>
                            </fieldset>

                            <div class="form-group"><input class="form-control" type="text"
                                                           placeholder="Заработная плата"
                                                           name="pay"
                                                           value="{{ old('pay', $default['pay']) }}"></div>
                            <fieldset class="form-group">
                                <div>Отделы</div>
                                @foreach ($departments as $department)
                                    <div class="checkbox">
                                        <label>
                                            <input
                                                    @if(in_array($department->id, $oldDepartments)) checked @endif
                                            type="checkbox" name="departments[]" value="{{$department->id}}">
                                            {{$department->name}}</label>

                                    </div>
                                @endforeach
                            </fieldset>
                            <button type="submit" id="update-employee-{{ $default['id'] }}" class="btn btn-save">
                                Сохранить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
