<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth'); // if you dont want any users to show any data use this
    }

    public function index()
    {
        $todos = Todo::all(); // variable must be plural to pass and loop
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'todo_name' => 'required'
        ]);

        $todo = new Todo([
            'todo_name' => $request->get('todo_name')
        ]);
        $todo->user_id = auth()->user()->id;
        $todo->save();
        
        return response()->json(array('success' => true, 'last_insert_id' => $todo->id), 200);
        //return redirect('/todos')->with('success', 'Todo Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::find($id);
        if(auth()->user()->id !== $todo->user_id){
            return redirect('/todos')->with('error', 'Unauthorized Page');
        }
        return view('todos.index',compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'todo_name' => 'required'
        ]);

        $todo = Todo::find($id);
        $todo->todo_name = $request->get('todo_name');
        $todo->save();
        
        
        //return redirect('/todos')->with('success', 'Task Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if(auth()->user()->id !== $todo->user_id){
            return redirect('/todos')->with('error', 'Unauthorized Page');
        }
        $todo->delete();

        //return redirect('/todos')->with('success', 'Task Deleted');
    }
}
