<p>Your tasks</p>
<a href={{ route('item.add.form') }}>Add Taks</a>

@php
    $currentDate = now();
@endphp

<ul>
    @foreach ($tasks as $task)
    <li>
      <a href={{ route('item.get', ['id' => $task->id]) }}>{{ $task->name }}/{{ $task->priority }}/{{ $task->start_time }}/{{ $task->status }}</a>&nbsp;&nbsp;&nbsp;
      @if ($task->uuid != null && $currentDate <= $task->expire)
      <a href={{ route('item.show', ['uuid' => $task->uuid]) }}>Link</a>&nbsp;&nbsp;&nbsp;
      @endif
      <a href={{ route('item.history', ['id' => $task->id]) }}>History</a>&nbsp;&nbsp;&nbsp;
      <form method="POST" action={{ route('item.publish', ['id' => $task->id]) }} style="display: inline-block;">
        @csrf
        <button style="font-size: 6px; padding: 2px 5px;" type="submit">Publish</button>
      </form>
      <form method="POST" action={{ route('item.delete', ['id' => $task->id]) }} style="display: inline-block;">
        @csrf
        <button style="font-size: 6px; padding: 2px 5px;" type="submit">Delete</button>
      </form>
    </li>
    @endforeach
</ul>

<h3>Filtr</h3>
<form method="GET">
  <label for="priority">Filtr priority:</label><br>
  <select name="priority" id="priority"><br>
   <option value=""></option>
    @foreach ($form['priorities'] as $priority)
    <option value={{ $priority }}>{{ $priority }}</option>
    @endforeach
  </select><br>
  <label for="start_time">Filtr date:</label><br>
  <input type="datetime-local" id="start_time" name="start_time"><br>
  <label for="status">Filtr status:</label><br>
  <select name="status" id="status"><br>
    <option value=""></option>
    @foreach ($form['statuses'] as $status)
    <option value="{{ $status }}">{{ $status }}</option>
    @endforeach
  </select><br>
  <button type="submit">Filtr</button>
</form>

<br><br><br>
<form method="POST" action={{ route('logout') }}>
  @csrf
  <button type="submit">Logout</button>
</form>



