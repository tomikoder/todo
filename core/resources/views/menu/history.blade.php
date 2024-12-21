<h1>History</h1>

@foreach ($task->taskHistory as $task)
<p>Name: {{ $task->name }}</p>
<p>Description: {{ $task->description }}</p>
<p>Priority: {{ $task->priority }}</p>
<p>Status: {{ $task->status }}</p>
<p>Start time: {{ $task->start_time }}</p>
<p>Required time: {{ $task->req_time }}</p>
<hr>
@endforeach