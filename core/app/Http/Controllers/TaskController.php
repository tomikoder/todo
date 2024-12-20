<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Task;
use App\Models\TaskHistory;

class TaskController extends Controller
{
    private const QUERY_PARAMS = ['status', 'deadline', 'priority'];
    private const PRIORITIES = ['low', 'medium', 'high'];
    private const STATUSES = ['to-do', 'in progress', 'done'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tasks = $request->user()->tasks;
        foreach ($request->query as $key => $val) {
            if (!in_array($key, self::QUERY_PARAMS) || !$val) {
                continue;
            }

            $tasks = $tasks->where($key, $val);
        }

        return view('menu.list', [
            'tasks' => $tasks,
            'form' => [
                'priorities' => self::PRIORITIES,
                'statuses' => self::STATUSES,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('menu.add', [
            'form' => [
                'priorities' => self::PRIORITIES,
            ]
        ]);
    }

    private function saveInHistory(array $dataToInsert, Task $task): void
    {
        $dataToInsert['task_id'] = $task->id;
        TaskHistory::create($dataToInsert);
    }

    private function formatStatuses(): string
    {
        return implode(',', self::STATUSES);
    }

    private function formatPriorities(): string
    {
        return implode(',', self::PRIORITIES);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $dataToInsert = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'priority' => 'required|string|in:' . $this->formatPriorities(),
            'deadline' => 'required|date|after_or_equal:today',
        ]);

        $dataToInsert['user_id'] = $request->user()->id;
        $task = Task::create($dataToInsert);
        $this->saveInHistory($dataToInsert, $task);
        return Redirect::route('item.list');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $task = Task::findOrFail($id);

        if ($request->user()->cannot('update', $task)) {
            abort(403);
        }

        $dataToInsert = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'priority' => 'required|string|in:' . $this->formatPriorities(),
            'deadline' => 'required|date|after_or_equal:today',
            'status'  => 'required|string|in:' . $this->formatStatuses()
        ]);

        $dataToInsert['send_notify'] = true;
        $task->update($dataToInsert);
        $dataToInsert['task_id'] = $task->id;
        $this->saveInHistory($dataToInsert, $task);
        return Redirect::route('item.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): View
    {
        $task = Task::where('uuid', $uuid)
            ->where('expire', '>=', now())
            ->firstOrFail();
        return view('menu.show', ['task' => $task]);
    }

    public function publish(Request $request, string $id): RedirectResponse
    {
        $task = Task::findOrFail($id);

        if ($request->user()->cannot('update', $task)) {
            abort(403);
        }

        $task->uuid = (string) Str::uuid();
        $task->expire = Carbon::now()->addWeek();
        $task->save();
        return Redirect::route('item.list');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id): View
    {
        $task = Task::findOrFail($id);

        if ($request->user()->cannot('update', $task)) {
            abort(403);
        }

        return view('menu.get', [
            'task' => $task,
            'form' => [
                'priorities' => self::PRIORITIES,
                'statuses' => self::STATUSES
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): RedirectResponse
    {
        $task = Task::findOrFail($id);

        if ($request->user()->cannot('delete', $task)) {
            abort(403);
        }

        $task->delete();
        return Redirect::route('item.list');
    }

    public function history(Request $request, string $id): View
    {
        $task = Task::findOrFail(id: $id);

        if ($request->user()->cannot('showHistory', $task)) {
            abort(403);
        }

        return view('menu.history', ['task' => $task]);
    }
}
