<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart; // Added this line

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $user_email = Auth::check() ? Auth::user()->email : null;
        $session_id = Session::getId();

        if (empty($product_id)) {
            return redirect()->back()->with('error', 'Не хватает данных.');
        }

        $product = DB::table('Товары')->where('id', $product_id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Товар не найден.');
        }

        $query = DB::table('carts')->where('product_id', $product_id);
        if ($user_email) {
            $query->where('user_email', $user_email);
        } else {
            $query->where('session_id', $session_id);
        }
        $cartItem = $query->first();

        if ($cartItem) {
            $updateData = ['quantity' => $cartItem->quantity + $quantity];
            $query = DB::table('carts')->where('product_id', $product_id);
            if ($user_email) {
                $query->where('user_email', $user_email);
            } else {
                $query->where('session_id', $session_id);
            }
            $query->update($updateData);
        } else {
            $data = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if ($user_email) {
                $data['user_email'] = $user_email;
            } else {
                $data['session_id'] = $session_id;
            }
            DB::table('carts')->insert($data);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }
    
    public function updateQuantity(Request $request)
    {
        $product_id = $request->input('product_id');
        $action = $request->input('action'); // 'increment' or 'decrement'
        $user_email = Auth::check() ? Auth::user()->email : null;
        $session_id = Session::getId();

        if (empty($product_id) || !in_array($action, ['increment', 'decrement'])) {
            return response()->json(['error' => 'Некорректные данные'], 400);
        }

        $query = DB::table('carts')->where('product_id', $product_id);
        if ($user_email) {
            $query->where('user_email', $user_email);
        } else {
            $query->where('session_id', $session_id);
        }
        $cartItem = $query->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Товар не найден в корзине'], 404);
        }

        $newQuantity = $cartItem->quantity;

        if ($action === 'increment') {
            $newQuantity++;
        } elseif ($action === 'decrement') {
            $newQuantity = max(1, $newQuantity - 1); // Ensure quantity doesn't go below 1
        }

        DB::table('carts')
            ->where('product_id', $product_id)
            ->when($user_email, function ($query) use ($user_email) {
                return $query->where('user_email', $user_email);
            }, function ($query) use ($session_id) {
                return $query->where('session_id', $session_id);
            })
            ->update(['quantity' => $newQuantity]);

        return response()->json(['success' => true, 'quantity' => $newQuantity]);
    }

    public function removeFromCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $user_email = Auth::check() ? Auth::user()->email : null;
        $session_id = Session::getId();

        if (empty($product_id)) {
            return redirect()->back()->with('error', 'Некорректные данные');
        }

        $query = Cart::where('product_id', $product_id);

        if ($user_email) {
            $query->where('user_email', $user_email);
        } else {
            $query->where('session_id', $session_id);
        }

        $cartItem = $query->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Товар не найден в корзине');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }
}