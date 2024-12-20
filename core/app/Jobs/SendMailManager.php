<?php

namespace App\Jobs;

use App\Jobs\UserEmailSendingJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;


class SendMailManager
{
    public function __invoke()
    {
        $tasks = DB::table('tasks');
        foreach ($tasks as $task) {
            UserEmailSendingJob::dispatch($task, $task->user());
        }
    }
}