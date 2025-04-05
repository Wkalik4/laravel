<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartUserController extends Controller
{
    public function index(): View
    {
        $cartItemsWithProducts = [];

        // Получаем элементы корзины в зависимости от аутентификации пользователя
        if (Auth::check()) {
            $userEmail = Auth::user()->email;
            $cartItems = DB::table('carts')->where('user_email', $userEmail)->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = DB::table('carts')->where('session_id', $sessionId)->get();
        }

        // Получаем информацию о товарах для каждого элемента корзины
        foreach ($cartItems as $cartItem) {
            $product = DB::table('nomenclatura')->find($cartItem->product_id);

            if ($product) {
                $cartItemsWithProducts[] = [
                    'cartItem' => $cartItem,
                    'product' => $product,
                ];
            }
        }

        // Возвращаем представление 'cart.index' с данными
        return view('cart.index', compact('cartItemsWithProducts'));
    }
}