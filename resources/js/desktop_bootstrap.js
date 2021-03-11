require('./bootstrap');
import Echo from "laravel-echo"
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '3c7e1846e0438952564f',
    cluster: 'ap3',
    encrypted: true
});
