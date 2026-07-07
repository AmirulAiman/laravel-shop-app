<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function review(Request $request){
        $selectedCartItem = $request->input('selected');

        $items = Auth::user()->cart->items()->whereIn('id', $selectedCartItem)->get();
        $total = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        return view('checkouts.review', compact('items', 'total'));
    }
    public function store(Request $request){
        DB::transaction(function () use ($request) {
            $selectedCartItem = $request->input('item_ids');
            $items = Auth::user()->cart->items()->whereIn('id', $selectedCartItem)->get();
            $totalPrice = $items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            //Create new order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            //Save cart items into order item
            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            //Delete the items in cart when saved to order table.
            Auth::user()->cart->items()->whereIn('id', $selectedCartItem)->delete();
        });
        return redirect()->route('dashboard')->with('success', 'Order placed successfully.');
    }
}
