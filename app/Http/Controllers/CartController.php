<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first(); //TODO:
        return view('cart.index', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]); //TODO:
        $item = $cart->items()->where('product_id', $request->product_id)->first();
        if($item){
            $item->quantity += $request->quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $item)
    {
        $this->authorize('update', $item);
        $request->validate(['quantity' => 'required|integer|min:1',]);
        $item->update([
            'quantity' => $request->quantity,
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();
        return redirect()->route('carts.index')->with('success', 'Cart item deleted successfully.');
    }
}
