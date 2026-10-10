<?php

namespace App\Http\Controllers;

use App\Models\LeadershipMessage;
use Illuminate\View\View;

class LeadershipMessageController extends Controller
{
    public function show(LeadershipMessage $leadershipMessage): View
    {
        abort_unless($leadershipMessage->is_active, 404);

        return view('leadership.show', [
            'message' => $leadershipMessage,
        ]);
    }
}
