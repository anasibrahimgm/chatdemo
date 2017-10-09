<template>
  <div class="chat-composer">
    <input v-model="newMessage" type="text" placeholder="Start  Typing Your Message" @keyup.enter="sendMessage"/>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newMessage: '',
    }
  },

  methods: {
    sendMessage() {
      console.log(this.newMessage, "Sent");
      this.$emit('messagesent', {
        message: this.newMessage,
        user: {
          name: $('.navbar-right .dropdown-toggle').text(),
        },
      });
      this.newMessage = '';
    },
  }
}
</script>

<style>
.chat-composer {
  display: flex;
  margin: 10px;
}

.chat-composer input{
  flex: 1 auto;
  border: none;
}

.chat-composer button{
  border-radius: 0;
}
</style>
