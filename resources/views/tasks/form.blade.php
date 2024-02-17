@section(
    'title',
    isset($task)
    ? 'Edit Task'
    : 'Add Task'
)

<a
    href="{{ route('tasks.index') }}"
    class="link"
>
    <- Go back to the tasks
</a>

<form
    method="POST"
    action="{{
        isset($task)
        ? route('tasks.update', ['task' => $task->id])
        : route('tasks.store')
    }}"
>
    @csrf

    @isset($task)
        @method('PUT')
    @endisset

    <div class="mb-4">
        <label for="title">
            Title
        </label>
        <input
            type="text"
            name="title"
            id="name"
            value="{{
                $task->title ?? old('title')
            }}"
            @class(['border-red-500' => $errors->has('title')])
        >
        @error('title')
            <p class="error">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="description">
            Description
        </label>
        <textarea
            name="description"
            id="description"
            cols="30"
            rows="5"
            @class(['border-red-500' => $errors->has('description')])
        >
            {{
                $task->description ?? old('description')
            }}
        </textarea>
        @error('description')
            <p class="error">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="long_description">
            Long Description
        </label>
        <textarea
            name="long_description"
            id="long_description"
            cols="30"
            rows="10"
            @class(['border-red-500' => $errors->has('long_description')])
        >
            {{
                $task->long_description ?? old('long_description')
            }}
        </textarea>
        @error('long_description')
            <p class="error">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <button
            type="submit"
            class="btn btn-success"
        >
            @isset($task)
                Update Task
            @else
                Add Task
            @endisset
        </button>
    </div>
</form>
