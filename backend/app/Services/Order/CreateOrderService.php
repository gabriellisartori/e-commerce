<?php

namespace App\Services\Order;

use App\Models\Order;

class CreateOrderService
{
    public function handle(array $attributes): Order
    {
        $order = new Order($attributes);

        $order->save();

        return $order;
    }
}