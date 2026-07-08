<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(){}
    public function updateStatus(Request $request, OrderItem $orderItem){
        $this->authorize('update', $orderItem);
        $validated = $request->validate($request, [
            'status' => 'required|in:pending,processing,shipped,delivered,canceled',
        ]);
        $orderItem->update($validated);
        return redirect()->back()->with('success', 'Order item status updated successfully.');
    }
    public function updateOrder(Request $request, Order $order){}

}
