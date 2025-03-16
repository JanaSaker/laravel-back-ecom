<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems'])->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created order in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'sometimes|string|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    /**
     * Display the specified order.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        return response()->json($order->load(['user', 'orderItems']));
    }

    /**
     * Update the specified order in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'total_price' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|string|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    /**
     * Remove the specified order from the database.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}