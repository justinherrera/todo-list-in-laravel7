@extends('layouts.app')

@section('content')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Add New Todo</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('todos.store') }}">
          @csrf
          <div class="form-group">    
              <label for="first_name">Todo Name:</label>
              <input type="text" class="form-control" name="todo_name"/>
          </div>                   
          <button type="submit" class="btn btn-success">New Todo</button>
      </form>
  </div>
</div>
</div>
@endsection