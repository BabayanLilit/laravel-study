<?php
/** @var \App\Department[] $departments[] */

$title = 'Сотрудники';
?>

@extends('layouts.app')
@section('title')
    {{  $title }}
@endsection

@section('content')
<div class="container departments">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default department-list">
                <div class="panel-heading"> {{$title}}
                    <a href="{{ url('department/create/')}}" class="btn btn-default add-button">Добавить</a>
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">

                        <!-- Table Headings -->
                        <thead>
                        <th>Название отдела</th>
                        <th>Количество сотрудников отдела</th>
                        <th>Максимальная заработная плата среди сотрудников отдела.</th>
                        <th>Ред. </th>
                        <th>Уд. </th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <td>
                                    {{ $department->name }}
                                </td>
                                <td>
                                    {{ $department->employees_count }}
                                </td>
                                <td>
                                    @if(isset($maxPays[$department->id]))
                                        {{ $maxPays[$department->id] }}
                                    @endif
                                </td>

                                <td>
                                    <a href="/department/{{ $department->id }}/edit/"><img src="/img/icons/edit.png"></a>
                                </td>
                                <td>
                                    <form action="{{ url('department/'.$department->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <img class="delete-button" src="/img/icons/delete.png">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
