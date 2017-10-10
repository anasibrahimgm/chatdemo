@extends('layouts.app')

@section('title', "Chat Room")

@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h1>Chatroom</h1>
        <span class="badge pull-right">@{{ usersInRoom.length }}</span>
      </div>

      <div class="panel-body">
        <chat-log :messages="messages"></chat-log>
        <chat-composer v-on:messagesent="addMessage"></chat-composer>
      </div>
    </div>
  </div>
@endsection
