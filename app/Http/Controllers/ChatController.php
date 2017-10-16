<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Events\newMessage;

class ChatController extends Controller
{
      public function index()
      {
        return Auth::user()->chatrooms()
                            ->with('users', 'messages')
                            ->orderBy('updated_at', 'desc')
                            ->get();
      }

      public function newMessage(Request $request)
      {
          $this->validate($request, [
            'message' => 'required|string',
            'chatroom_id' => 'required|integer',
          ]);
          // Store the new message
          $message = Auth::user()->messages()->create([
              'message' => $request->message,
              'chatroom_id' => $request->chatroom_id,
          ]);
          // Announce that a new message has been posted
          broadcast(new newMessage($message))->toOthers();
          return ['status' => 'Message Added', 'message' => $message];
      }
}
