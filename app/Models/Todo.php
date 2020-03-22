<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['todo_name'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
