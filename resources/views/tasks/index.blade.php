@extends('layouts.app')

@section('title', 'To Do List')

@section('content')
    <div>
        <a href="{{ route('tasks.create') }}">Add new</a>
        @forelse ($tasks as $task)
            <div>
                <a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->title }}</a>
            </div>
        @empty
            <div>There are no Tasks!</div>
        @endforelse

        @if ($tasks->count())
            <div>{{ $tasks->links() }}</div>
        @endif
    </div>
@endsection
