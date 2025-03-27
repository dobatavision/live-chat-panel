<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('chat.{userIds}', function ($user, $userIds) {
    $ids = explode('-', $userIds);
    return in_array($user->id, $ids); // Allow access if the user is authenticated and part of the chat
});

