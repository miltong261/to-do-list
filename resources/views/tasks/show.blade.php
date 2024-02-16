@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <a href="{{ route('tasks.index') }}">Regresar</a>

    <p>{{ $task->description }}</p>

    @if ($task->long_description)
        <p>{{ $task->long_description }}</p>
    @endif

    <p>{{ $task->created_at }}</p>
    <p>{{ $task->updated_at }}</p>

    <form action="{{ route('tasks.toggle-complete', ['task' => $task->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit">Mark as {{ $task->completed ? 'not completed' : 'completed' }}!</button>
    </form>

    <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">Edit</a>
    <form action="{{ route('tasks.destroy', ['task' => $task->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
@endsection

