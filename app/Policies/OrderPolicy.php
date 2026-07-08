<?php

namespace App\Policies;

use App\Models\OrderItem;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}
    public function update(User $user, OrderItem $orderItem): bool
    {
        // Allow only the admin, shop owner, or the user who placed the order to update the order item status
        return $user->role == 'admin' || $user->role == 'shop_owner' || $user->id === $orderItem->order->user_id;
    }
}
