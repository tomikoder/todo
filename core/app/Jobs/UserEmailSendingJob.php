<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Task;
use App\Mail\NotifyEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserEmailSendingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasks = Task::whereDate('deadline', Carbon::today())->get();
        foreach ($tasks as $task) {
            Mail::to($task->user->email)->send(new NotifyEmail());
        }
    }
}
