<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message', 'chatroom_id', 'user_id',
    ];

    protected $table = 'chatdemo_messages';

    protected $touches = ['chatroom'];

    protected $hidden = [
        'id', 'chatroom_id','updated_at',
    ];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function chatroom() {
      return $this->belongsTo(ChatRoom::class, 'chatroom_id');
    }
}
