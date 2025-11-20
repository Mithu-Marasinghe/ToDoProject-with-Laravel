<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Team_Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = DB::table('team__Members')
            ->join('teams', 'team__members.team_id','=','teams.id')
            ->where('team__members.user_id', Auth::user()->id)
            ->select(
                'teams.id as id',
                'teams.team_name as team_name',
                'teams.owner_id as owner_id',
            )
            ->get();
        return view('home', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function view(Team $team) 
    {
        $members = DB::table('team__members')
            ->join('users', 'team__members.user_id', '=', 'users.id')
            ->where('team__members.team_id', $team->id)
            ->select(
                'team__members.id as member_id',
                'users.name',
                'users.email',
                'team__members.role'
            )
            ->get();
        
        $tasks = DB::table('tasks')
            ->where('team_id', $team->id)
            ->select('*')
            ->get();

        return view('team', [
            'team' => $team,
            'members' => $members,
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string',
        ]);
        
        $data = Team::create([
            'team_name'=>$request->team_name,
            'owner_id' => Auth::id(),

        ]);

        Team_Members::create([
            'team_id'=> $data->id,
            'user_id'=> Auth::id(),
            'role'=> 'owner'
        ]);

        return redirect('home')->with('success',
            'Team Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $team = Team::findOrFail($request->team_id);
        $team->delete();

        return redirect()->route('home')->with('success', 
            'Team deleted successfully!');
    }
    
}
