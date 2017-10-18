<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Events\newMessage;
use App\User;
use App\ChatRoom;

class ChatController extends Controller
{
      public function index()
      {
        $allUsers = User::where('id', '<>', Auth::id())->get();//all users except Auth::user()
        $authUser = Auth::user();
        $chatrooms = $authUser->chatrooms()
                            ->with('users', 'messages')
                            ->orderBy('updated_at', 'desc')
                            ->get();
        return ['allUsers' => $allUsers, 'authUser' => $authUser, 'chatrooms' => $chatrooms];
      }

      public function newMessage(Request $request)
      {
          $this->validate($request, [
            'message' => 'required|string',
            'chatroom_id' => 'required|integer',
            'receiver_id' => 'required|integer',
          ]);
          $chatroom_id = $request->chatroom_id;

          if (!$request->chatroom_id) {//new chat room with chatroom_id = 0
            $chatroom = new ChatRoom();
            $chatroom->save();
            $chatroom_id = $chatroom->id;

            Auth::user()->chatrooms()->attach($chatroom_id);
            $receiver = User::find($request->receiver_id);
            $receiver->chatrooms()->attach($chatroom_id);
          }

          // Store the new message
          $message = Auth::user()->messages()->create([
              'message' => $request->message,
              'chatroom_id' => $chatroom_id,
          ]);
          // Announce that a new message has been posted
          broadcast(new newMessage($message))->toOthers();
          return ['status' => 'Message Added', 'message' => $message];
      }

      public function chatUsers()
      {
        $chatrooms = Auth::user()->chatrooms()->get();
        $chatUsers = [];
        foreach ($chatrooms as $chatroom) {
          $id = ( ($chatroom->users[0]->id == Auth::id()) ? $chatroom->users[1]->id : $chatroom->users[0]->id );
          array_push($chatUsers, $id);
        }
        return ['chatUsers' => $chatUsers];
      }
}
