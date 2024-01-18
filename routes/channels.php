<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
// TODO:: Study the channel thing
Broadcast::channel('App.Models.Admin.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
}, ['guards' => ['admin']]);



Broadcast::channel('group-chat', function ($user) {
    return $user;
}, ['guards' => ['admin']]);


Broadcast::channel('myChannel', function () {
    return true;
});



