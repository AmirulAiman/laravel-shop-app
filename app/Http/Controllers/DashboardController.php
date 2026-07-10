<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            // Admin dashboard logic
            $totalUsers = User::count();
            $totalNewUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

            $totalCustomers = User::where('role', 'customer')->count();
            $totalNewCustomers = User::where('role', 'customer')->where('created_at', '>=', Carbon::now()->subDays(7))->count();

            $totalSellers = User::where('role', 'shop_owner')->count();
            $totalNewSellers = User::where('role', 'shop_owner')->where('created_at', '>=', Carbon::now()->subDays(7))->count();

            $totalProducts = Product::count();
            $orderCreatedWithinTheWeek = Order::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count();
            $orders = Order::with('items.product')->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->latest()->get();

            return view('dashboard.index', compact('totalUsers', 'totalNewUsers', 'totalCustomers', 'totalNewCustomers', 'totalSellers', 'totalNewSellers', 'totalProducts', 'orderCreatedWithinTheWeek', 'orders'));
        } elseif ($role === 'shop_owner') {
            //TODO: Implement shop owner dashboard logic
            $orders = Order::with('items.product')->latest()->get();
            return view('dashboard.index');
        } else {
            // Customer dashboard logic
            $orders = Auth::user()->orders()->with('items.product')->latest()->get();
            return view('dashboard.index', compact('orders'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
