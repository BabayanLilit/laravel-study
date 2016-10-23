<?php

/** @var \App\Department $department */
$title = 'Редактирование отдела - ' . $department->name;

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
                    <div class="department-form-container">
                        @include('common.errors')
                        <form action="{{ url('department/'. $department->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group"><input class="form-control" type="text" placeholder="Название отдела"
                                                           name="name"
                                                           required
                                                           value="{{ old('name', $department->name) }}"></div>
                            <button type="submit" id="update-department-{{ $department->id }}" class="btn btn-save">
                                Сохранить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
