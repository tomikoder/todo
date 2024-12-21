<p>Add item</p>
<form method="POST" action={{ route('item.add.form') }}>
  @csrf
  <label for="name">Task name:</label><br>
  <input type="text" id="name" name="name"><br>
  @if ($errors->has('name'))
  <div style="color: red;" class="error">{{ $errors->first('name') }}</div>
  @endif
  <label for="description">Task description:</label><br>
  <input type="text" id="description" name="description"><br>
  @if ($errors->has('description'))
  <div style="color: red;" class="error">{{ $errors->first('description') }}</div>
  @endif
  <label for="priority">Choose a priority:</label><br>
  <select name="priority" id="priority"><br>
    @foreach ($form['priorities'] as $priority)
    <option value={{ $priority }}>{{ $priority }}</option>
    @endforeach
  </select><br>
  @if ($errors->has('priority'))
  <div style="color: red;" class="error">{{ $errors->first('priority') }}</div>
  @endif
  <label for="start_time">Start time:</label><br>
  <input type="datetime-local" id="start_time" name="start_time"><br>
  @if ($errors->has('start_time'))
  <div style="color: red;" class="error">{{ $errors->first('start_time') }}</div>
  @endif
  <label for="req_time">Required time:</label><br>
  <input type="time" id="req_time" name="req_time"><br>
  @if ($errors->has('req_time'))
  <div style="color: red;" class="error">{{ $errors->first('req_time') }}</div>
  @endif
  <button type="submit">Send</button>
</form> 
