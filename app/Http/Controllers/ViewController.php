<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function dashboard(){
        
        $count['completed'] = Task::where('status', '=', 'Completed')->count();
        $count['progres'] = Task::where('status', '=', 'In Progress')->count();
        $count['hold'] = Task::where('status', '=', 'Hold')->count();

        $count['user'] = User::all()->count();

        

        return view('dashboard', $count);   
    }
}
