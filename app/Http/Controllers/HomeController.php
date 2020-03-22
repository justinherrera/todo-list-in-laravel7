<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $todos = Todo::all(); // variable must be plural to pass and loop
        // return view('todos.index', compact('todos'));
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        
        return view('todos.index')->with('todos', $user->todos);
    }
}
