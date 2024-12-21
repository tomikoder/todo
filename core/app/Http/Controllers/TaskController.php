<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Constants\TaskConstants;
use App\Models\Task;
use App\Events\TaskAdded;
use App\Events\TaskUpdated;
use App\Events\TaskDeleted;

class TaskController extends Controller
{
    private const QUERY_PARAMS = ['status', 'start_time', 'priority'];

    public function index(Request $request): View
    {
        $tasks = $request->user()->tasks;
        foreach ($request->query as $key => $val) {
            if (!in_array($key, self::QUERY_PARAMS) || !$val) {
                continue;
            }
            if ($key == self::QUERY_PARAMS[1]) {
                $val = Carbon::parse($val);
            }
            $tasks = $tasks->where($key, $val);
        }

        return view('menu.list', [
            'tasks' => $tasks,
            'form' => [
                'priorities' => TaskConstants::PRIORITIES,
                'statuses' => TaskConstants::STATUSES,
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
                'priorities' => TaskConstants::PRIORITIES,
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     */

    private function validationRules(bool $includeStatus = false): array
    {
        $rules = [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'priority' => 'required|string|in:' . implode(separator: ',', array: TaskConstants::PRIORITIES),
            'start_time' => 'required|date|after_or_equal:today',
            'req_time' => 'required|date_format:H:i'
        ];

        if ($includeStatus) {
            $rules['status'] = 'required|string|in:' . implode(separator: ',', array: TaskConstants::STATUSES);
        }

        return $rules;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $dataToInsert = $request->validate($this->validationRules());
        $task = new Task();
        $task->fill($dataToInsert);
        $task->user_id = $request->user()->id;
        $task->save();
        $task->history()->create($dataToInsert);
        event(new TaskAdded($task));
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

        $dataToInsert = $request->validate($this->validationRules(true));

        $dataToInsert['send_notify'] = true;
        $task->update($dataToInsert);
        $task->history()->create($dataToInsert);
        event(new TaskUpdated($task));
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
                'priorities' => TaskConstants::PRIORITIES,
                'statuses' => TaskConstants::STATUSES
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

        event(new TaskDeleted($task));
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
