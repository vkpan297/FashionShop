@extends('layouts.admin')

@section('title')
    <title>Send Mail</title>
@endsection

@section('css')
    <link href="{{ asset('adminStyle/slider/index/list.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('paginate.css')}}">
    <style>
        .panel{
            margin-left: 17%;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="panel-body panel" style="margin-bottom: 30px">
        <form action="{{ route('store.task') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="card">
                <h5 class="card-header">
                    New Task
                </h5>
                <div class="card-body row">
                    <label class="col-sm-2" for="task-name"><b>Task</b></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Enter task..." name="name">
                    </div>
                    <!-- Add Task Button -->
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            Add Task
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if (count($tasks) > 0)
        <div class="card panel">
            <h5 class="card-header">
                Current Tasks
            </h5>
            <div class="card-body">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <!-- Table Headings -->
                            <thead>
                            <th>Task</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="table-text">
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td>

                                            <a href="{{ route('delete.task',['id'=>$task->id]) }}" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script src="{{ asset('vendor/sweetAleert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('adminStyle/slider/index/list.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/f714ee491f.js" crossorigin="anonymous"></script>
@endsection


