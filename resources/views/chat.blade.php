<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chat Room</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    </head>
    <body>
      <div id="app">
        <h1>Chatroom</h1>
        <chat-log :messages="messages"></chat-log>
        <chat-composer v-on:messagesent="addMessage"></chat-composer>
      </div>

      <script src="{{ asset('js/app.js') }}">
      </script>
    </body>
</html>
