<template>
  <div class="chat-log">
    <div class="chat-log-left">
      <ul class="nav nav-pills nav-stacked">
        <li v-for="chatroom in chatrooms" :id="'chatroomli'+chatroom.id" :class="chatroom.id === chatrooms[0].id ? 'active' : ''"><a data-toggle="pill" :href="'#chatroom'+chatroom.id">
          {{ chatroom.users[0].id == chatroom.pivot.user_id ? chatroom.users[1].name : chatroom.users[0].name }}
          <i class="fa fa-user-circle-o" aria-hidden="true" style="float:right;"></i>
        </a></li>
      </ul>
    </div>

  <div class="tab-content chat-log-right">
    <chat-room v-for="chatroom in chatrooms"
                :chatroom="chatroom" :id="'chatroom'+chatroom.id"
                :class="'tab-pane fade'  +  (chatroom.id === chatrooms[0].id ? 'in active' : '')"
                >
    </chat-room>
  </div>
  </div>
</template>

<script>
export default {
  props: ['chatrooms'],

  data() {
    return {
      usersInRoom: [],
    }
  },

  methods: {

  },

  created() {
   }
}
</script>

<style>
a {
  color: #000 !important;
}

.activeI {
  color: green;
}

.chat-log {
  overflow: hidden;
  box-sizing: border-box;
  margin: 0 10px;
}

.chat-log-left {
  float: left;
  width: 25%;
  box-sizing: border-box;
  overflow: hidden;
}

.chat-log-right {
  float: right;
  width: 75%;
  box-sizing: border-box;
  overflow: hidden;
}

.nav-pills > li.active > a {
  background-color: #ccc !important;
}
</style>
