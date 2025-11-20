<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        $request->validate([
            'taskValue' => 'required',
        ]);

        Tasks::create([
            'team_id' => $request->team_id,
            'task' => $request->taskValue,
        ]);

        return redirect('/team/' . $request->team_id);
    }

    public function deleteTask(Request $request)
    {
        $task = Tasks::findOrFail($request->task_id);
        $task->delete();

        return redirect('/team/' . $request->team_id);
    }
}
