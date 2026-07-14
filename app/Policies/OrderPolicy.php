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
    public function update(User $user, OrderItem $orderItem, String $newStatus): bool
    {
        // Allow only the admin, shop owner, or the user who placed the order to update the order item status
        if ($user->isAdmin()) {
            return ! in_array($newStatus, ['delivered', 'cancelled']);
        }
        if ($user->isCustomer()) {
             return $orderItem->user_id === $user->id
            && $orderItem->status === 'shipped'
            && $newStatus === 'delivered';
        }
        return false;
    }
}
