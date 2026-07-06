<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(){}
    public function updateItem(Request $request, OrderItem $orderItem){}
    public function updateOrder(Request $request, Order $order){}

}
