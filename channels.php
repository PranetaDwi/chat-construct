<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Chat;
use App\Models\ProjectProgress;
use App\Broadcasting\ChatChannel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat-message.{userId}', function (User $user, int $receiver_id) {
//     return $user->id === Chat::findOrNew($receiver_id)->user_id;
// });

// Broadcast::channel('chat-message.{receiverId}', function ($user, $receiverId) {
//     return (int) $user->id == (int) $receiverId;
// });

Broadcast::channel('project-progress.{project_progress_id}', ChatChannel::class);

// Broadcast::channel('project-progress.{project_progress_id}', function ($user, $project_progress_id) {
//     $projectProgress = ProjectProgress::find($project_progress_id);
//     return $user->account_id === $projectProgress->buyer_id || $user->account_id === $projectProgress->developer_id;
// });