<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getCart(Request $request)
    {
        $user = $request->user();

        $cart = $user->cart;

        if (!$cart) {
            return response()->json(['message' => 'User does not have a cart.']);
        }

        $items = $cart->items;
        return response()->json(['cart_items' => $items]);
    }

    public function addProductToCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => ['required', 'string'],
            'quantity' => ['required', 'integer']
        ]);

        $user = $request->user();
        $cart = $user->cart;

        try {
            // check cart exist
            if (!$cart) {
                $cart = Cart::create(['user_id' => $user->id]);
            }

            // check product exist
            $product_id = $request->product_id;
            $product = Product::where('id', $product_id)->first();

            if (!$product || $product->quantity < $request->quantity) {
                return response()->json(['message' => 'Product not found or insufficient stock!'], 404);
            }

            // check product exist in cartItems
            $cartProduct = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product_id)
                ->first();

            if ($cartProduct) {
                $cartProduct->update([
                    'quantity' => $request->quantity
                ]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product_id,
                    'quantity' => $request->quantity
                ]);
            }
        } catch (Error $err) {
            throw $err;
        }

        return response()->json(['message' => 'Product added to cart successfully!']);
    }

    public function deleteProductFromCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => ['required', 'string']
        ]);

        $user = $request->user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $product_id = $request->product_id;
        $item = $cart->items()->where('product_id', $product_id)->first();

        if (!$item) {
            return response()->json(['message' => 'Product not found in cart!'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Product deleted from cart successfully']);
    }

    public function deleteCart(Request $request, Cart $cart)
    {
        $user = $request->user();
        $cart = $user->cart;

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->delete();

        return response()->json(['message' => 'Cart deleted successfully!']);
    }
}
