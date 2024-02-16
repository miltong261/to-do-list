@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <form method="POST" action="{{ route('tasks.update', ['task' => $task->id]) }}">
        @csrf
        @method('PUT')

        <label for="title">Title</label>
        <input type="text" name="title" id="name" value="{{ $task->title }}">
        @error('title')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="5">{{ $task->description }}</textarea>
        @error('description')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label for="long_description">Long Description</label>
        <textarea name="long_description" id="long_description" cols="30" rows="10">{{ $task->long_description }}</textarea>
        @error('long_description')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <button type="submit">Update Task</button>
    </form>
@endsection
