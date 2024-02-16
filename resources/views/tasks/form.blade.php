@section('title', isset($task) ? 'Edit Task' : 'Add Task')

<form method="POST" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
    @csrf

    @isset($task)
        @method('PUT')
    @endisset

    <label for="title">Title</label>
    <input type="text" name="title" id="name" value="{{ $task->title ?? old('title') }}">
    @error('title')
        <p class="error-message">{{ $message }}</p>
    @enderror

    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="5">{{ $task->description ?? old('description') }}</textarea>
    @error('description')
        <p class="error-message">{{ $message }}</p>
    @enderror

    <label for="long_description">Long Description</label>
    <textarea name="long_description" id="long_description" cols="30" rows="10">{{ $task->long_description ?? old('long_description') }}</textarea>
    @error('long_description')
        <p class="error-message">{{ $message }}</p>
    @enderror

    <button type="submit">
        @isset($task)
            Update Task
        @else
            Add Task
        @endisset
    </button>
</form>
