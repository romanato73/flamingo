<?php


namespace App\Controllers;


use App\Models\Task;
use Flamingo\Interfaces\ResourceController;

class TaskController implements ResourceController
{
    /**
     * Show all tasks.
     *
     * @return mixed
     */
    public function index()
    {
        $tasks = Task::orderBy('completed', 'asc')
            ->orderBy('updated_at', 'desc')
            ->paginate(4);

        return view('tasks/index', ['tasks' => $tasks]);
    }

    /**
     * Create form for tasks.
     *
     * @return mixed
     */
    public function create()
    {
        return view('tasks/create');
    }

    /**
     * Store task into database.
     */
    public function store()
    {
        $task = new Task;

        $task->description = request('description');
        $task->completed = 0;

        $task->save();

        redirect('tasks');
    }

    /**
     * Show task with specific id.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $task = Task::find($id);

        return view('tasks/show', ['task' => $task]);
    }

    /**
     * Edit form for specific task.
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $task = Task::find($id);

        return view('tasks/edit', ['task' => $task]);
    }

    /**
     * Update specific task.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $task = Task::find($id);

        if (request('completed', true)) {
            // Update status
            $task->completed = request('completed');

            $task->save();
        }

        if (request('description', true)) {
            // Update description
            $task->description = request('description');

            $task->save();
        }

        return view('tasks/show', ['task' => $task]);
    }

    /**
     * Delete specific task.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        $task->delete();

        return redirect('tasks');
    }
}