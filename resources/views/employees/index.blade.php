<?php
/** @var \App\Employee[] $employees */

$title = 'Сотрудники';
?>

@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="container employees">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default employee-list">
                <div class="panel-heading"> {{$title}}
                    <a href="{{ url('employee/create/')}}" class="btn btn-default add-button">Добавить</a>
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">

                        <!-- Table Headings -->
                        <thead>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Пол</th>
                        <th>Заработная плата</th>
                        <th>Названия отделов в которых работает сотрудник</th>
                        <th>Ред. </th>
                        <th>Уд. </th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>
                                    {{ $employee->name }}
                                </td>
                                <td>
                                    {{ $employee->lastname }}
                                </td>
                                <td>
                                    {{ $employee->patronymic }}
                                </td>
                                <td>
                                    {{ $employee->getGenderLabel() }}
                                </td>
                                <td>
                                    {{ $employee->pay }}
                                </td>
                                <td>
                                    {{ $employee->getDepartmentsNames() }}
                                </td>
                                <td>
                                    <a href="/employee/{{ $employee->id }}/edit/"><img src="/img/icons/edit.png"></a>
                                </td>
                                <td>
                                    <form action="{{ url('employee/'.$employee->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <img class="delete-button" src="/img/icons/delete.png">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
