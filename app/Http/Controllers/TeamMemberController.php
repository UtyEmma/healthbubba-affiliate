<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TeamMemberController extends Controller{

    function index(Request $request) {
        $users = User::isMarketer()
                    ->withCount('referrals')
                    ->when($request->keyword, function($query, $keyword){
                        $query->where('firstname', 'LIKE', "%{$keyword}%")
                            ->orWhere('firstname', 'LIKE', "%{$keyword}%")
                            ->orWhere('email', 'LIKE', "%{$keyword}%")
                            ->orWhere('code', 'LIKE', "%{$keyword}%");
                    })
                    ->orderByDesc('referrals_count')->paginate();
        return view('user.index', compact('users'));
    }

    function show(Request $request, User $user) {
        $query = $user->referrals();
        $doctors = $user->referrals()->isFromTeam()->whereType('doctor')->count(); 
        $patients = $user->referrals()->isFromTeam()->whereType('patient')->count(); 
        $referrals = $query->whereNotNull('referral_code')->isFromTeam()->latest('created_at')->paginate();
        $referrals_count = $query->whereNotNull('referral_code')->isFromTeam()->latest('created_at')->count();
        return view('user.show', compact('user', 'referrals', 'patients', 'doctors', 'referrals_count'));
    }

}
