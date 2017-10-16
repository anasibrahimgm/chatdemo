<template>
  <div class="chat-room">
    <div v-for="message in chatroom.messages"  :class="'chat-message ' + (message.user_id == chatroom.pivot.user_id ? 'sender' : 'receiver')">
      <div class="msg-text">
        <p style="margin-bottom:0;">{{ message.message }}</p>
        <small style="text-align:right;">{{ message.created_at }}</small>
      </div>
    </div>
    <chat-composer v-on:messagesent="addMessage"></chat-composer>
  </div>
</template>
<script>
export default {
  props: ['chatroom'],

  data() {
    return {
      usersInRoom: [],
    }
  },

  methods: {
    addMessage(message) {
      // push to the DB
      axios.post('/messages', {
        message: message,
        chatroom_id: this.chatroom.id,
      })
      .then(response => {
        // Add to existing messages
        this.chatroom.messages.push(response.data.message);
      })
      .catch(error => {
        if (error.response) {
          console.log("Error 1");
           console.log(error.response);

         } else if (error.request) {
           console.log("Error 2");
           console.log(error.request);
         } else {
           console.log("Error 3");
           console.log('Error', error.message);
         }
      });
    }
  },

  created() {
    var element = '#chatroomli' + this.chatroom.id + ' i';

    Echo.join(`chatroom.${this.chatroom.id}`)
        .here((users) => {
            this.usersInRoom = users;
            if (this.usersInRoom.length == 2 )
              $(element).addClass('activeI');
        })
        .joining((user) => {
            this.usersInRoom.push(user);
            $(element).addClass('activeI');
        })
        .leaving((user) => {
            this.usersInRoom = this.usersInRoom.filter(u => u != user);
            $(element).removeClass('activeI');
        })
        .listen('newMessage', (e) => {
          this.chatroom.messages.push(e.message);
        });
  },
}
</script>

<style>
.chat-room {
  margin: 0 5px;
  border: 1px solid #ccc;
}

.chat-message {
  overflow: hidden;
  box-sizing: border-box;
  margin: 5px;
}

.msg-text {
  padding: 2px 4px;
  margin-bottom: 0;
  border-radius: 4px;
  font-size: 14px;
  color: #FFF;
}

.receiver .msg-text{
  background-color: #ccc;
  max-width: 70%;
  float: left;
  box-sizing: border-box;
  overflow: hidden;
}

.sender .msg-text {
  max-width: 70%;
  float: right;
  box-sizing: border-box;
  overflow: hidden;
  background-color: #3097D1;
}

small {
  font-size: 70%;
  color: #777777 !important;
}
</style>
