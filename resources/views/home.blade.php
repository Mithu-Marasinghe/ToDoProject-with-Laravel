<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
</head>
<body>
    @if(Auth::check())
    <div class="flex">
        <form method="POST" action="{{ route('logout') }}"> 
            @csrf
            <button type="submit">Logout</button>
        </form>

        @if(session('success'))
            <p style="color: red;">{{ session('success') }}</p>
        @endif
        
        <form method="POST" action="{{ route('createTeam') }}"> 
            @csrf
            <input type="text" name="team_name" placeholder="Enter Team Name">
            <button type="submit">Create Team</button>
        </form>
        
        <p>Your Teams:</p>
        @if ($teams->isEmpty())
            <p>No teams found.</p>
        @endif  
        @foreach($teams as $team)
            <div>
                <form method="post" action="{{ route('deleteTeam') }}">
                    @csrf
                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                    <a href="{{ route('viewTeam', ['team' => $team->id]) }}">
                        {{ $team->team_name }}
                    </a>
                    @if (Auth::user()->id == $team->owner_id)
                        <button type="submit">Delete</button> <br><br>
                    @endif
                </form>
            </div>
        @endforeach    
    </div>

    @else
    <p>Please log in to view your Teams</p>
    <form method="GET" action="{{ route('showLogin') }}"> 
        @csrf
        <button type="submit">Log In</button>
    </form>
    @endif
</body>
</html>