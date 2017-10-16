<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'chatdemo_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at', 'updated_at',
    ];

    public function chatrooms() {
      return $this->belongsToMany(ChatRoom::class, 'chatdemo_chatroom_user', 'user_id', 'chatroom_id');
    }

    public function messages() {
      return $this->hasMany(Message::class);
    }

}
