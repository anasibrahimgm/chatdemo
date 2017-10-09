<template>
  <div class="chat-message">
    <p>{{ message.message }}</p>
    <small>{{ message.user.name }}</small>
  </div>
</template>

<script>
export default {
  props:['message',],

  data() {
    return {
    }
  }
}
</script>

<style lang="css">
.chat-message {
    padding: 1rem;
}
.chat-message > p {
    margin-bottom: .5rem;
}
</style>
