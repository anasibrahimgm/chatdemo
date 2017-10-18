<template>
  <div class="chat-room">
    <p v-show="!chatroom.messages.length">Say Hi...</p>
    <div v-for="(message, index) in chatroom.messages"  :class="'chat-message ' + (message.user_id == authUser.id ? 'sender' : 'receiver')">
      <div class="msg-text">
        <p style="margin-bottom:0;">{{ message.message }}</p>
        <small style="text-align:right;">{{ message.created_at }}</small>
        <h5 style="color: #F00;text-align: right;font-size: small;font-style: italic;" v-show="message.newMessageError">{{ message.newMessageError }}<span style="cursor:pointer;" @click="addFailedMessage(message.message, index)">Try Again</span></h5>
      </div>
    </div>
    <chat-composer v-on:messagesent="addMessage"></chat-composer>
  </div>
</template>
<script>
export default {
  props: ['authUser', 'chatroom'],

  data() {
    return {
      receiver: {},
      usersInRoom: [],
      date: new Date(),
    }
  },

  methods: {
    addFailedMessage(message, index) {
      this.addMessage(message);
      this.chatroom.messages[index] = {};
    },

    addMessage(message) {
      // Add to existing messages
      this.chatroom.messages.push({
        message: message,
        newMessageError: '',
        user_id: this.authUser.id,
        created_at: this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate() + ' ' + this.date.getHours() + '-' + this.date.getMinutes() + '-' + this.date.getSeconds(),
      });
      // push to the DB
      axios.post('/messages', {
        message: message,
        chatroom_id: this.chatroom.id,
        receiver_id: this.receiver.id,
      })
      .then(response => {

      })
      .catch(error => {
        this.chatroom.messages[this.chatroom.messages.length - 1].newMessageError = 'Error..Not Sent! ';
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
    this.receiver = ( (this.chatroom.users[0].id == this.authUser.id) ? this.chatroom.users[1] : this.chatroom.users[0] );

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
