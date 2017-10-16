<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{    
    protected $hidden = [
        'created_at',
    ];

    protected $table = 'chatdemo_chatrooms';

    public function users() {
      return $this->belongsToMany(User::class, 'chatdemo_chatroom_user', 'chatroom_id', 'user_id');
    }

    public function messages() {
      return $this->hasMany(Message::class, 'chatroom_id');
    }
}
