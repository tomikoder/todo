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
  <label for="deadline">Deadline:</label><br>
  <input type="date" id="deadline" name="deadline"><br>
  @if ($errors->has('deadline'))
  <div style="color: red;" class="error">{{ $errors->first('deadline') }}</div>
  @endif
  <button type="submit">Send</button>
</form> 
