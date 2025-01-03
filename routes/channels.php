<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('users.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders.{orderId}', function (User $user, $orderId) {
    if ($user->id !== Order::findOrNew($orderId)->user_id) {
        return false;
    }

    return true;
});

// Presence channel
Broadcast::channel('rooms.{roomId}', function (User $user, $roomId) {
    return $user->only('id', 'name');
});

// Whispering
Broadcast::channel('app', function(User $user) {
    return true;
});
