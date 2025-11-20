<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $team->team_name }}</title>
</head>

<body>
    <a href="{{ route('home') }}">
        <button type="button">Back</button>
    </a>

    <h1>{{$team->team_name}}</h1>

    <form method="POST" action="{{ route('team.invite', $team->id) }}">
        @csrf
        <button type="submit">Invite Member</button>
    </form>

    @if(session('success'))
    <p>Invite Link: <a href="{{ session('success') }}">{{ session('success') }}</a></p>
    @endif
    <br>

    <form method="post" action="{{ route('createTask', ['team' => $team->id]) }}">
        @csrf
        <input type="hidden" name='team_id' value="{{ $team->id }}">
        <textarea type='text' name='taskValue' placeholder="Enter Task"></textarea><br>
        <button type="submit">Add Task</button>
    </form>

    <h2>Task List:</h2>
    @foreach($tasks as $task)
    <li>
        {{ $task->task }}
        <form method="post" action="{{ route('deleteTask', ['team' => $team->id]) }}">
            @csrf
            <input type="hidden" name='team_id' value="{{ $team->id }}">
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <button type="submit">Delete</button>
        </form>
    </li>
    @endforeach
    <br>

    <h2>Member List:</h2>
    @foreach($members as $member)
    <li>
        {{ $member->name }}
        ({{ $member->role }})
    </li>
    @endforeach
</body>

</html>