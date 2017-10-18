<template>
  <div class="chat-log">
    <div class="chat-log-left">
      <ul class="nav nav-pills nav-stacked">
        <div class="dropdown" style="margin-bottom: 10px;">
          <input v-model="search" type="text" class="form-control dropdown-toggle" data-toggle="dropdown" placeholder="search..." />
          <ul class="dropdown-menu">
            <li v-for="user in filteredUsers" @click="newChatRoom(user)"><a href="#">{{ user.name }}</a></li>
          </ul>
        </div>

        <li v-for="chatroom in chatrooms" :id="'chatroomli'+chatroom.id" :class="chatroom.id === chatrooms[0].id ? 'active' : ''"><a data-toggle="pill" :href="'#chatroom'+chatroom.id">
          {{ chatroom.users[0].id == authUser.id ? chatroom.users[1].name : chatroom.users[0].name }}
          <i class="fa fa-user-circle-o" aria-hidden="true" style="float:right;"></i>
        </a></li>
      </ul>
    </div>

  <div class="tab-content chat-log-right">
    <chat-room v-for="chatroom in chatrooms"
                :authUser="authUser"
                :chatroom="chatroom" :id="'chatroom'+chatroom.id"
                :class="'tab-pane fade'  +  (chatroom.id === chatrooms[0].id ? 'in active' : '')"
                >
    </chat-room>
  </div>
  </div>
</template>

<script>
export default {
  props: ['allUsers', 'authUser', 'chatrooms'],

  data() {
    return {
      usersInRoom: [],
      search: '',
      chatUsers: [],
    }
  },

  methods: {
    newChatRoom(user) {
      const position  = this.chatUsers.findIndex(
        (element) => {
          return element == user.id;
        }
      );
      // console.log("position:", position);

      if(position < 0) {//not found in chatUsers
        this.chatUsers.push(user.id);
        this.addChatroom(user);
      }
    },

    addChatroom(user){
      this.chatrooms.unshift({
          "id": 0,
          "messages": [],
          "users": [{'id':this.authUser.id }, user],
        });
      // $('#chatroom1').removeClass('active');
      // $('#chatroom0').addClass('active');
    },
  },

  created() {
    axios.get('/chatusers').then(response => {
        this.chatUsers = response.data.chatUsers;
        // console.log('this.chatUsers: ', this.chatUsers);
    });
  },

  computed: {
    filteredUsers() {
      return this.allUsers.filter((user) => {
        return user.name.match(this.search);
      });
      // console.log('this.allUsers:', this.allUsers);
    },
  },
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
