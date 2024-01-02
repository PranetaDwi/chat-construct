<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\ProjectProgress;

class ChatChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $project_progress_id)
    {

        
        $projectProgress = ProjectProgress::find($project_progress_id);
        return $projectProgress && (
            $user->account_id === $projectProgress->buyer_id || 
            $user->account_id === $projectProgress->developer_id
        );
    }

    
}
