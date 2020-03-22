@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="display-3">Task-to-do</h1>    
    <form id = "addForm">
        @csrf
        <div class="input-group mb-3">
            <input type="text" autocomplete="off" class="form-control todo_name_field" name = "todo_name" placeholder="Add New Task">
            <div class="input-group-append">
            <button type = "submit" class="btn btn-primary send" type="submit">New Todo</button>  
            <button class="btn btn-danger clear" type="button">Clear</button>  
            </div>
        </div>
    </form>
        <small style = "font-size: 20px;">Task-to-do <span class="badge badge-primary"></span> </small>
  <table class="table table-striped table-dark">
    <tbody>
        @forelse($todos as $todo)
        <tr class = "row-{{$todo->id}}">
            <td>{{$todo->todo_name}}</td>
            <td class = "time-{{$todo->id}}">{{$todo->updated_at->diffForHumans()}}</td>
            <td><button class="btn btn-info status" data-id="{{ $todo->id }}" type="button">Pending...</button></td>
            <td>
                {{-- {{ route('todos.edit',$todo->id)} --}}
                @if(!Auth::guest())
                    <a id = "edit" href="" data-id="{{ $todo->id }}" data-name="{{ $todo->todo_name }}" class="btn btn-primary" data-toggle="modal">Edit</a>
                    </td>
                    <td>
                    <form id ="#deleteForm" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn btn-danger delete" data-id={{ $todo->id }} type="submit">Delete</button>
                    </form>
                @endif
            </td>
            
        </tr>
        @empty
            <p>No data to be displayed</p>
        @endforelse
    </tbody>
  </table>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    
                    <form id = "form-data" method="post">
                        @method("PUT")
                        @csrf
                        <div class="form-group">
                        {{-- <input type="hidden" class="todo_id form-control" name="todo_id" value="{{old('todo_id', $todo->todo_id)}}" /> --}}
                            <label for="todo_name">Todo Name:</label>
                            <input type="text" class="todo_name form-control" name="todo_name" />
                        </div>
                    
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success save">Save</button>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
</div>
@endsection