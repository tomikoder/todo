<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Task;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    private const QUERY_PARAMS = ['status', 'deadline', 'priority'];
    private const PRIORITIES = ['low','medium', 'high'];
    private const STATUSES = ['to-do', 'in progress', 'done'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tasks = $request->user()->tasks;
        foreach ($request->query as $key => $val) {
            if (!in_array($key, self::QUERY_PARAMS) || !$val) continue;
            $tasks = $tasks->where($key, $val);
        }

        return view('menu.list', [
            'tasks' => $tasks, 
            'priorities' => self::PRIORITIES,
            'statuses' => self::STATUSES
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.add', [
            'form' => [
            'priorities' => self::PRIORITIES,
            'statuses' => self::STATUSES
        ]]);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tasks|max:255',
            'description' => 'required||max:255',
            'priority' => 'required|string|in:low,medium,high',
            'deadline' => 'required|date|after_or_equal:today'
        ]);

        $validated['user_id'] = $request->user()->id;        
        Task::create($validated);
        return Redirect::route('item.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        return view('menu.get', ['task' => $task, 'form' => ['priorities' => self::PRIORITIES]]);   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
