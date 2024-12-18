<p>Your tasks</p>
<a href={{ route('item.add.form') }}>Add Taks</a>

<ul>
    @foreach ($tasks as $task)
    <li><a href={{ route('item.get', ['id' => $task->id]) }}>{{ $task->name }}/{{ $task->priority }}/{{ $task->deadline }}/{{ $task->status }}</a></li>
    @endforeach
</ul>

<h3>Sort</h3>
<form method="GET">
  <label for="priority">Sorta priority:</label><br>
  <select name="priority" id="priority"><br>
   <option value=""></option>
    @foreach ($priorities as $priority)
    <option value={{ $priority }}>{{ $priority }}</option>
    @endforeach
  </select><br>
  <label for="deadline">Sort date:</label><br>
  <input type="date" id="deadline" name="deadline"><br>
  <label for="status">Sort status:</label><br>
  <select name="status" id="status"><br>
    <option value=""></option>
    @foreach ($statuses as $status)
    <option value="{{ $status }}">{{ $status }}</option>
    @endforeach
  </select><br>
  <button type="submit">Send</button>
</form>

<form method="POST" action={{ route('logout') }}>
  @csrf
  <button type="submit">Logout</button>
</form>


