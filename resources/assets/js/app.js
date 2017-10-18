
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

Vue.component('chat-log', require('./components/chatLog.vue'));
Vue.component('chat-room', require('./components/chatRoom.vue'));
Vue.component('chat-composer', require('./components/chatComposer.vue'));

const app = new Vue({
    el: '#app',

    data() {
      return {
        allUsers: [],
        authUser: {},
        chatrooms: [],
      }
    },

    methods: {

    },

    created() {
       axios.get('/chatrooms').then(response => {
          // console.log('response: ', response);
           this.authUser = response.data.authUser;
           this.allUsers = response.data.allUsers;
           this.chatrooms = response.data.chatrooms;
       });
   }
});
