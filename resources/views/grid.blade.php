<?php
/** @var \App\Employee[] $employees */
/** @var \App\Department $department */

$title = 'Сетка';

?>

@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="container employees">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default e">
                <div class="panel-heading"> {{$title}}
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">

                        <!-- Table Headings -->
                        <thead>
                        <th></th>
                        @foreach ($departments as $department)
                            <th>{{ $department->name }}</th>
                        @endforeach
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <th>
                                    {{ $employee->lastname }} {{ $employee->name }}
                                </th>
                                @foreach ($departments as $department)
                                    <td>
                                        @if(in_array($department->id , $employee->departments->pluck('id')->toArray()))
                                            +
                                        @endif
                                    </td>
                                @endforeach
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
