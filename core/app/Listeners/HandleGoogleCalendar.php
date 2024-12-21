<?php

declare(strict_types=1);

namespace App\Listeners;

use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use App\Events\Interfaces\GoogleCalendarEventInterface;
use App\Events\TaskAdded;
use App\Events\TaskDeleted;
use App\Events\TaskUpdated;
use App\Models\Task;

class HandleGoogleCalendar
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(GoogleCalendarEventInterface $event): void
    {
        $task = $event->task;
        if ($event instanceof TaskAdded) {
            $googleEvent = new Event();
            $this->updateEvent($googleEvent, $task);
            $eventId = Event::get()->last()->id;
            $task->google_calender_event_id = $eventId;
            $task->save();
        } elseif ($event instanceof TaskUpdated) {
            $googleEvent = Event::find($task->google_calender_event_id);
            $this->updateEvent($googleEvent, $task);
        } elseif ($event instanceof TaskDeleted) {
            $googleEvent = Event::find($task->google_calender_event_id);
            $googleEvent->delete();
        }
    }

    private function updateEvent(Event $googleEvent, Task $task): void
    {
        $endTime = Carbon::createFromFormat('H:i', $task->req_time);
        $googleEvent->startDateTime  = Carbon::parse($task->start_time);
        $googleEvent->endDateTime = Carbon::parse($task->start_time)
            ->addHours($endTime->hour)
            ->addMinutes($endTime->minute);
        $googleEvent->name = $task->name;
        $googleEvent->save();
    }
}
