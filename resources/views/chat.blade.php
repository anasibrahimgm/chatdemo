@extends('layouts.app')

@section('title', "Chat Room")

@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1>Chatroom</h1>
      </div>

      <div class="panel-body">
        <chat-log :auth-user="authUser" :chatrooms="chatrooms" :all-users="allUsers"></chat-log>
      </div>
    </div>
  </div>
@endsection
