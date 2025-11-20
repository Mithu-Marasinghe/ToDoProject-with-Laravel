<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function createInvite(Request $request, Team $team)
    {
        $token = Str::random(32);

        DB::table('team_invites')->insert([
            'team_id' => $team->id,
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $inviteLink = url('/invite/' . $token);

        return back()->with('success', $inviteLink);
    }

    public function acceptInvite($token)
    {
        $invite = DB::table('team_invites')->where('token', $token)->first();

        if (!$invite) {
            abort(404, "Invalid Invite");
        }

        if (!Auth::check()) {
            return redirect('/auth/login')->with('invite_token', $token);
        }
        
        $alreadyMember = DB::table('team__members')
            ->where('team_id', $invite->team_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$alreadyMember) {
            DB::table('team__members')->insert([
                'team_id' => $invite->team_id,
                'user_id' => Auth::id(),
                'role' => 'member',
            ]);

            return redirect()->route('home')->with('success', 'You joined the team!');
        } else {
            return redirect()->route('home')->with('success', 'You are already in the team!');
        }
    }
}
