<?php

declare(strict_types=1);

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyEmail;
use App\Models\Task;

class UserEmailSendingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasks = Task::whereDate('deadline', Carbon::tomorrow())
            ->where('send_notify', true)
            ->whereNot('status', 'done')
            ->get();
        foreach ($tasks as $task) {
            $task->send_notify = false;
            $task->save();
            Mail::to($task->user->email)->send(new NotifyEmail($task));
        }
    }
}
