<?php

namespace App\Http\Controllers\Web\MonitoringChat\ChatController;

use App\Events\ChatSend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\ProjectProgress;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

class ChatController extends Controller
{

    public function postSendChat(Request $request, $project_progress_id){

        $user_id = Auth::user()->account_id;

        $role = Auth::user()->role;
        if ($role == "developer"){
            $receiver_account_id = ProjectProgress::where('id', $project_progress_id)->value('buyer_id');
        } elseif ( $role == "user"){
            $receiver_account_id = ProjectProgress::where('id', $project_progress_id)->value('developer_id');
        }

        $newChat= Chat::create([
            'project_progress_id' => $project_progress_id,
            'sender_id' => $user_id,
            'receiver_id' => $receiver_account_id,
            'message' => $request->message,
            'status' => 'unread'
        ]);

        $lastMessage = Chat::where('project_progress_id',$project_progress_id)->latest()->first();

        if($lastMessage->sender_id === $user_id){
            $updateChats = Chat::where('receiver_id', $user_id)->where('project_progress_id', $project_progress_id)->where('status','unread')->get();
            foreach ($updateChats as $updateChat ){
                $updateChat->update(['status' => 'read']);
            };
        };
        
        broadcast(new ChatSend($newChat->message, $project_progress_id, $user_id, $newChat->sender_id, $newChat->receiver_id, $newChat->created_at));

        return response()->json(['state' => 1, 'messages' => $newChat]);

    }
}
