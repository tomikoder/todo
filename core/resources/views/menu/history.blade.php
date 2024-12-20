<h1>History</h1>

@foreach ($task->taskHistory as $task)
<p>test</p>
<p>Name: {{ $task->name }}</p>
<p>Description: {{ $task->description }}</p>
<p>Priority: {{ $task->priority }}</p>
<p>Status: {{ $task->status }}</p>
<p>Deadline: {{ $task->deadline }}</p>
<hr>
@endforeach