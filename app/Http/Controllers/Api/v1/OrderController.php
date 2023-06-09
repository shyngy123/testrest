<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\Order\PlaceOrderRequest;

class OrderController extends Controller
{

    public function placeOrder(PlaceOrderRequest $request)
{
    // Валидация входных данных
    $data = $request->validated();

    // Получение корзины текущего пользователя
    $cart = Cart::where('user_id', $request->user()->id)->firstOrFail();

    // Создание заказа
    $order = new Order();
    $order->user_id = $request->user()->id;
    $order->contact_name = $request->contact_name;
    $order->contact_email = $request->contact_email;
    $order->save();

    // Добавление продуктов из корзины в заказ
    foreach ($cart->products as $product) {
        $order->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
    }

    // Очистка корзины
    $cart->products()->detach();

    return response()->json(['message' => 'Order placed']);
}

public function index(Request $request)
{

    // Получение списка оформленных заказов текущего пользователя
    $orders = Order::where('user_id', $request->user()->id)->get();

    return response()->json($orders);
}

}
