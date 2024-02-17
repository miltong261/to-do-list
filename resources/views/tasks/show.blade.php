@extends('layouts.app')

@section(
    'title',
    $task->title
)

@section('content')
    <div class="mb-4">
        <a
            href="{{ route('tasks.index') }}"
            class="link"
        >
            <- Go back to the tasks
        </a>
    </div>

    <p class="mb-4 text-slate-700">
        {{ $task->description }}
    </p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700">
            {{ $task->long_description }}
        </p>
    @endif

    <p class="mb-4 text-sm text-slate-500">
        Created at {{ $task->created_at->diffForHumans() }} - Updated at {{ $task->updated_at->diffForHumans() }}
    </p>

    <p class="mb-4">
        @if ($task->completed)
            <span class="font-medium text-green-500">
                Completed
            </span>
        @else
            <span class="font-medium text-red-500">
                Not completed
            </span>
        @endif
    </p>

    <div class="flex gap-2">
        <form
            action="{{ route('tasks.toggle-complete', ['task' => $task->id]) }}"
            method="POST"
        >
            @csrf

            @method('PUT')

            <button
                type="submit"
                class="btn btn-toggle"
            >
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}!
            </button>
        </form>

        <a
            href="{{ route('tasks.edit', ['task' => $task->id]) }}"
            class="btn btn-edit"
        >
            Edit
        </a>

        <form
            action="{{ route('tasks.destroy', ['task' => $task->id]) }}"
            method="POST"
        >
            @csrf

            @method('DELETE')

            <button
                type="submit"
                class="btn btn-delete"
            >
                Eliminar
            </button>
        </form>
    </div>
@endsection

