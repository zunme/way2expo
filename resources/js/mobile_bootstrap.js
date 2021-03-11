require('./bootstrap');
import Echo from "laravel-echo"
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '7329a3432e24b43e5d85',
    cluster: 'ap3',
    encrypted: true
});
//import Vue from 'vue';
window.$$ = window.jQuery = require('jquery');