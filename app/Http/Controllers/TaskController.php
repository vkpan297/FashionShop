<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\tasks;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $tasks;
    public function __construct(tasks $tasks){
        $this->tasks=$tasks;
    }
    public function index(){
        $tasks=tasks::all();
        return view('admin.task.index', compact('tasks'));
    }
    public function store(Request $request)
    {
        $task=new tasks();
        $task->name = $request->name;
        $task->save();

        $users=User::all();
        $message = [
            'type' => 'Create task',
            'task' => $task->name,
            'content' => 'has been created!',
        ];
        SendEmail::dispatch($message,$users)->delay(now()->addMinute(1));
        return redirect()->back();
    }

    public function delete($id)
    {
        $task=$this->tasks->find($id);
        $task->delete();

        $users=User::all();
        $message = [
            'type' => 'Delete task',
            'task' => $task->name,
            'content' => 'has been deleted!',
        ];
        SendEmail::dispatch($message,$users)->delay(now()->addMinute(1));

        return redirect()->route('task.index');
    }
}
