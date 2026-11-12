<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $today = today(config('app.timezone'));
        $tasks = Task::whereDate('task_date', $today)->orderBy('id')->get();
        $pendingCount = $tasks->where('status', 'pending')->count();
        $completedCount = $tasks->where('status', 'completed')->count();
        $completionRate = $tasks->isEmpty() ? 0 : (int) round($completedCount / $tasks->count() * 100);

        return view('welcome', compact('today', 'tasks', 'pendingCount', 'completedCount', 'completionRate'));
    }
}
