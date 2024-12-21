<p>Edit item</p>
<form method="POST" action={{ route('item.get.update', ['id' => $task->id]) }}>
  @csrf
  <label for="name">Task name:</label><br>
  <input type="text" id="name" name="name" value="{{ $task->name }}"><br>
  @if ($errors->has('name'))
  <div style="color: red;" class="error">{{ $errors->first('name') }}</div>
  @endif
  <label for="description">Task description:</label><br>
  <input type="text" id="description" name="description" value="{{ $task->description }}"><br>
  @if ($errors->has('description'))
  <div style="color: red;" class="error">{{ $errors->first('description') }}</div>
  @endif
  <label for="priority">Choose a priority:</label><br>
  <select name="priority" id="priority"><br>
    @foreach ($form['priorities'] as $priority)
    @if ($priority != $task->priority)
    <option value="{{ $priority }}">{{ $priority }}</option>
    @else
    <option value="{{ $priority }}" selected>{{ $priority }}</option>
    @endif
    @endforeach
  </select><br>
  @if ($errors->has('priority'))
  <div style="color: red;" class="error">{{ $errors->first('priority') }}</div>
  @endif
  <label for="status">Choose a status:</label><br>
  <select name="status" id="status"><br>
    @foreach ($form['statuses'] as $status)
    @if ($status != $task->status)
    <option value="{{ $status }}">{{ $status }}</option>
    @else
    <option value="{{ $status }}" selected>{{ $status }}</option>
    @endif
    @endforeach
  </select><br>
  @if ($errors->has('status'))
  <div style="color: red;" class="error">{{ $errors->first('status') }}</div>
  @endif
  <label for="start_time">Start time:</label><br>
  <input type="datetime-local" id="start_time" name="start_time" value="{{ $task->start_time }}"><br>
  @if ($errors->has('start_time'))
  <div style="color: red;" class="error">{{ $errors->first('start_time') }}</div>
  @endif
  <label for="req_time">Required time:</label><br>
  <input type="time" id="req_time" name="req_time" value="{{ \Carbon\Carbon::parse($task->req_time)->format('H:i') }}"><br>
  @if ($errors->has('req_time'))
  <div style="color: red;" class="error">{{ $errors->first('req_time') }}</div>
  @endif
  <button type="submit">Edit</button>
</form> 
