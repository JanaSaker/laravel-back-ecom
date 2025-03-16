<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the order items.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();
        return response()->json($orderItems);
    }

    /**
     * Store a newly created order item in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderItem = OrderItem::create($validated);

        return response()->json($orderItem, 201);
    }

    /**
     * Display the specified order item.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(OrderItem $orderItem)
    {
        return response()->json($orderItem->load(['order', 'product']));
    }

    /**
     * Update the specified order item in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderItem $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'order_id' => 'sometimes|required|exists:orders,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $orderItem->update($validated);

        return response()->json($orderItem);
    }

    /**
     * Remove the specified order item from the database.
     *
     * @param \App\Models\OrderItem $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->json(['message' => 'Order item deleted successfully']);
    }
}