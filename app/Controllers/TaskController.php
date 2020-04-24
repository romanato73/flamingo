<?php


namespace App\Controllers;


use App\Models\Task;

class TaskController
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks', ['tasks' => $tasks]);
    }
}