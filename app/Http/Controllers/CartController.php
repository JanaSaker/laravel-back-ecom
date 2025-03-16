<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $carts = Cart::with(['user', 'product'])->get();
        return response()->json($carts);
    }

    /**
     * Store a newly created cart item in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::create($validated);

        return response()->json($cart, 201);
    }

    /**
     * Display the specified cart item.
     *
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Cart $cart)
    {
        return response()->json($cart->load(['user', 'product']));
    }

    /**
     * Update the specified cart item in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        $cart->update($validated);

        return response()->json($cart);
    }

    /**
     * Remove the specified cart item from the database.
     *
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(['message' => 'Cart item deleted successfully']);
    }
}