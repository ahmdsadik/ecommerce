/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

const chatHistoryBody = document.querySelector('.chat-history-body');

const messageInput = document.querySelector('.message-input');
const formSendMessage = document.querySelector('.form-send-message');
const onlineUsersDiv = document.getElementById('online-users');
const chatUl = document.getElementById('chat-msg');
const onlineCountSpan = document.getElementById('online-users-count');
const typingSpan = document.getElementById('typing');


let activeCount = 0;

function updateCount($count) {
    onlineCountSpan.innerText = $count;
}

function scrollToBottom() {
    chatHistoryBody.scrollTo(0, chatHistoryBody.scrollHeight);
}

window.Echo = new Echo({

    broadcaster: 'pusher',
    key: 'ecommerceAppKey',
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1', // Cluster is a must
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

// // Public Channel
// window.Echo.channel(`myChannel`)
//     .listen('NewMessageEvent', (e) => {
//         console.log('Public');
//         console.log(e.msg);
//         console.log('-----------------------------');
//     });
//
// // Private Channel
// window.Echo.private(`App.Models.Admin.${user_id}`)
//     .listen('NewMessageEvent', (e) => {
//         console.log('Private');
//         console.log(e.msg);
//         console.log('-----------------------------');
//     });


const channel = window.Echo.join(`group-chat`);

channel
    .here((users) => {

        activeCount = users.length - 1;

        updateCount(activeCount);

        let active_users = '';

        users.forEach(function (user) {

            if (user.id === +user_id) {
                return;
            }

            active_users += `<li id="user-${user.id}" class="chat-contact-list-item">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-online">
                                        <img src="${user.imgUrl}" alt="Avatar"
                                             class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-3">
                                        <h6 class="chat-contact-name text-truncate m-0">${user.name}</h6>
                                        <p class="chat-contact-status text-truncate mb-0 text-muted">UI/UX Designer</p>
                                    </div>
                                </a>
                            </li>`;
        });

        onlineUsersDiv.innerHTML += active_users;

        // console.log('Presence');
        // console.log(users.length);
    })
    .joining((user) => {

        activeCount++;

        updateCount(activeCount);

        onlineUsersDiv.innerHTML += `<li id="user-${user.id}" class="chat-contact-list-item">
                                <a class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-online">
                                        <img src="${user.imgUrl}" alt="Avatar"
                                             class="rounded-circle">
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-3">
                                        <h6 class="chat-contact-name text-truncate m-0">${user.name}</h6>
                                        <p class="chat-contact-status text-truncate mb-0 text-muted">UI/UX Designer</p>
                                    </div>
                                </a>
                            </li>`;

        chatUl.innerHTML += `<li class="chat-message">
                                    <div class="d-flex overflow-hidden shadow-lg">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0"><span class="text-primary">${user.name}</span> Joined the Chat</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>`;

        scrollToBottom();
    })
    .leaving((user) => {

        activeCount--;

        updateCount(activeCount);

        // Remove the user who leaved
        document.getElementById(`user-${user.id}`).remove();

        chatUl.innerHTML += `<li class="chat-message">
                                    <div class="d-flex overflow-hidden shadow-lg">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0"><span class="text-primary">${user.name}</span> left the Chat</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>`;

        scrollToBottom();

        // console.log(user.name);
    })
    .error((error) => {
        console.error(error);
    })
    .listen('NewMessageEvent', (e) => {
        var now = new Date();
        var timeString = now.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});


        chatUl.innerHTML += `<li class="chat-message">
                                    <div class="d-flex overflow-hidden">
                                        <div class="user-avatar flex-shrink-0 me-3">
                                            <div class="avatar avatar-sm">
                                                <img src="${e.msg.user.imgUrl}"
                                                     alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <small class="my-1 text-primary">
                                                    ${e.msg.user.name}
                                                </small>
                                                <p class="mb-0">${e.msg.body}</p>
                                            </div>
                                            <div class="text-muted mt-1">
                                                <small>${timeString}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>`;

        scrollToBottom();

        //
        // console.log('Presence');
        // console.log(e.msg.body);
        // console.log('-----------------------------');
    })
    .listenForWhisper('typing', function (event) {
        typingSpan.innerHTML = `<span class="text-primary">${event.name}</span>` + ' is typing ...';
    })
    .listenForWhisper('stop-typing', function (event) {
        typingSpan.innerHTML = '';
    });

// Send Message
formSendMessage.addEventListener('submit', e => {
    e.preventDefault();
    if (messageInput.value) {

        axios.post('messages', {
            "_token": csrf_token,
            "body": messageInput.value
        });

        let now = new Date();
        let timeString = now.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});


        chatUl.innerHTML += `<li class="chat-message chat-message-right">
                                    <div class="d-flex overflow-hidden">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text">
                                                <p class="mb-0">${messageInput.value}</p>
                                            </div>
                                            <div class="text-muted mt-1">
                                                <small>${timeString}</small>
                                            </div>
                                        </div>
                                    </div>
                            </li>`;

        messageInput.value = '';
        channel.whisper('stop-typing');
        scrollToBottom();
    }
});

messageInput.addEventListener('input', function (event) {

    if (messageInput.value.length === 0) {
        channel.whisper('stop-typing');
    } else {
        channel.whisper('typing', {
            name: user_name
        });
    }
});
