<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::orderBy('task_date')->orderBy('id')->get();

        return view('tasks.index', compact('tasks'));
    }
}
