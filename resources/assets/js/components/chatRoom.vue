<template>
  <div class="chat-room">
    <p>
      <i class="fa fa-user-circle-o fa-2x" aria-hidden="true" :style="'text-align:center;' + (usersInRoom.length == 2 ? 'color:green;':'')"></i>
    </p>
    <div class="chat-message" v-for="message in chatroom.messages" :class="message.user_id == chatroom.pivot.user_id ? 'sender' : 'receiver'">
      <span>{{ message.message }}</span>
      <br />
      <small>{{ message.created_at }}</small>
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
    Echo.join(`chatroom.${this.chatroom.id}`)
        .here((users) => {
            this.usersInRoom = users;
        })
        .joining((user) => {
            this.usersInRoom.push(user);
        })
        .leaving((user) => {
            this.usersInRoom = this.usersInRoom.filter(u => u != user)
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

.chat-room .chat-message{
  margin: 10px;
}

small {
  font-size: 70%;
  color: #FFF !important;
}

.sender {
  text-align: right;
  background-color: #3097D1;
}

.receiver {
  text-align: left;
  background-color: #ccc;
}

.sender span, .receiver span {
  max-width: 60%;
  font-size: 14px;
}

.sender, .receiver {
  color: #000;
  padding: 2px 4px;
  margin-bottom: 0;
  border-radius: 4px;
}

.empty {
  padding: 1rem;
  text-align: center;
}
</style>
