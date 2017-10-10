
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('chat-log', require('./components/chatLog.vue'));
Vue.component('chat-message', require('./components/chatMessage.vue'));
Vue.component('chat-composer', require('./components/chatComposer.vue'));

const app = new Vue({
    el: '#app',

    data() {
      return {
        messages: [],
        usersInRoom: [],
      }
    },

    methods: {
      addMessage(message) {
        // Add to the existing messages
        this.messages.push(message);

        // push to the DB
        axios.post('/messages', message)
        .then(response => {
          //console.log(response);
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
       axios.get('/messages').then(response => {
           this.messages = response.data;
       });

       Echo.join('chatroom')
           .here((users) => {
               this.usersInRoom = users;
              //  console.log("this.usersInRoom: ", this.usersInRoom[0].name);
           })
           .joining((user) => {
               this.usersInRoom.push(user);
           })
           .leaving((user) => {
               this.usersInRoom = this.usersInRoom.filter(u => u != user)
           })
           .listen('MessagePosted', (e) => {
               this.messages.push({
                   message: e.message.message,
                   user: e.user
               });
           });
   }
});
