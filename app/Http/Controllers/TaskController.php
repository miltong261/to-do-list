<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::latest()
            ->get();

        return view(
            'tasks.index',
            ['tasks' => $tasks]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'tasks.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        try {
            $task = Task::create(
                $request->only([
                    'title',
                    'description',
                    'long_description'
                ])
            );

            return redirect()
                ->route(
                    'tasks.show',
                    ['task' => $task->id]
                )
                ->with(
                    'success',
                    'Task created successfully!'
                );
        } catch (\Throwable $th) {
            return redirect()
                ->route(
                    'tasks.create'
                )
                ->with(
                    'error',
                    env('APP_DEBUG') ? $th->getMessage() : 'An error ocurred!'
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view(
            'tasks.show',
            ['task' => $task]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view(
            'tasks.edit',
            ['task' => $task]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        try {
            $task->update(
                $request->only([
                    'title',
                    'description',
                    'long_description'
                ])
            );

            return redirect()
                ->route(
                    'tasks.show',
                    ['task' => $task->id]
                )
                ->with(
                    'success',
                    'Task updated successfully!'
                );
        } catch (\Throwable $th) {
            return redirect()
                ->route(
                    'tasks.edit',
                    ['task' => $task]
                )
                ->with(
                    'error',
                    env('APP_DEBUG') ? $th->getMessage() : 'An error ocurred!'
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return redirect()
                ->route(
                    'tasks.index'
                )
                ->with(
                    'success',
                    'Task deleted successfully!'
                );
        } catch (\Throwable $th) {
            return redirect()
                ->route(
                    'tasks.show',
                    ['task' => $task->id]
                )
                ->with(
                    'error',
                    env('APP_DEBUG') ? $th->getMessage() : 'An error ocurred!'
                );
        }
    }
}
